<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\UserPlanStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Gift;
use App\Models\Order;
use App\Models\Product;
use App\Models\Room;
use App\Models\Service;
use App\Models\Sponser;
use App\Models\User;
use App\Models\UserPlan;
use App\Models\UserPlanDay;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class HomeController extends Controller
{


    public function root()
    {

        return view('index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function newOrdersData(Request $request)
    {
        return DataTables::eloquent($this->filter($request))
            ->addIndexColumn()
            ->addColumn('select', function ($row) {
                return '
                    <th scope="row">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="selectedItems[]" value="' . $row->id . '">
                        </div>
                    </th>
                ';
            })
            ->addColumn('user_name', function ($row) {
                $user = $row->user->name ? ($row->user->name) : $row->user->phone;
                return '<a href="' . route('users.show', $row->user_id) . '">' . $user . '</a>';
            })
            ->editColumn('sub_total', function ($row) {
                return $row->sub_total . ' ' . __('SAR');
            })
            ->editColumn('tax', function ($row) {
                return $row->tax ? $row->tax . ' ' . __('SAR') : '-';
            })
            ->editColumn('discount', function ($row) {
                return $row->discount ? $row->discount . ' ' . __('SAR') : '-';
            })
            ->editColumn('total', function ($row) {
                return $row->total . ' ' . __('SAR');
            })
            ->editColumn('status', function ($row) {
                if ($row->status == UserPlanStatusEnum::PENDING->value) {
                    $class = "bg-warning-subtle text-warning";
                } elseif ($row->status == UserPlanStatusEnum::IN_PROGRESS->value) {
                    $class = "bg-primary-subtle text-primary";
                } elseif ($row->status == UserPlanStatusEnum::COMPLETE->value) {
                    $class = "bg-success-subtle text-success";
                } else {
                    $class = "bg-danger-subtle text-danger";
                }
                return '<span class="badge ' . $class . ' text-uppercase"> ' . __($row->status) . ' </span>';
            })
            ->editColumn('payment_status', function ($row) {
                if ($row->payment_status == PaymentStatusEnum::PARTIAL_PAID->value) {
                    $class = "bg-primary-subtle text-primary";
                } elseif ($row->payment_status == PaymentStatusEnum::PAID->value) {
                    $class = "bg-success-subtle text-success";
                } else {
                    $class = "bg-warning-subtle text-warning";
                }
                return '<span class="badge ' . $class . ' text-uppercase"> ' . __($row->payment_status) . ' </span>';
            })
            ->addColumn('action', function ($row) {
                $actionButtons = '
                    <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="' . __('translation.Show') . '">
                        <a href="' . route('orders.show', $row->id) . '" class="text-primary d-inline-block edit-item-btn">
                            <i class="ri-eye-fill fs-16"></i>
                        </a>
                    </li>
                ';
                return '
                    <ul class="list-inline hstack gap-2 mb-0">
                        ' . $actionButtons . '
                    </ul>
                ';
            })->addColumn('plan', function ($row) {
                return $row->plan->title;
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->toDateString();
            })
            ->rawColumns(['select', 'user_name', 'action', 'status', 'payment_status', 'plan'])
            ->make();
    }

    /**
     * @param Request $request
     * @return Builder
     */
    public function filter(Request $request)
    {
        $UserPlansQuery = UserPlan::query()
            ->orderBy('id', 'desc')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
//        where('payment_status',PaymentStatusEnum::PAID->value)
            ->when($request->has('search_key') && $request->filled('search_key'), function ($query) use ($request) {
                $searchKey = $request->search_key;
                return $query->where(function ($query) use ($searchKey) {
                    $query->where('id', 'like', "%$searchKey%")
                        ->orWhere('sub_total', 'like', "%$searchKey%")
                        ->orWhere('tax', 'like', "%$searchKey%")
                        ->orWhere('total', 'like', "%$searchKey%");
                })
                    ->orWhereHas('user', function ($query) use ($searchKey) {
                        $query->where('name', 'like', "%$searchKey%");
                    });
            })
            ->when($request->has('from_date') && $request->filled('from_date'), function ($query) use ($request) {
                $query->where('created_at', '>=', $request->from_date);
            })
            ->when($request->has('to_date') && $request->filled('to_date'), function ($query) use ($request) {
                $query->where('created_at', '<=', $request->to_date);
            })
            ->when($request->has('status') && $request->filled('status') && $request->status != "all", function ($query) use ($request) {
                $query->where('status', $request->status);
            })->take(20);

        return $UserPlansQuery->with('user');
    }

    public function columns()
    {
        return [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
//            ['data' => 'order_number', 'name' => 'order_number', 'label' => __('UserPlan Number')],
            ['data' => 'plan', 'name' => 'plan', 'label' => 'الخطة'],
            ['data' => 'user_name', 'name' => 'user_name', 'label' => __('User Name')],
            ['data' => 'sub_total', 'name' => 'sub_total', 'label' => __('Sub Total')],
//            ['data' => 'tax', 'name' => 'tax', 'label' => __('Tax')],
            ['data' => 'discount', 'name' => 'discount', 'label' => __('Discount')],
            ['data' => 'total', 'name' => 'total', 'label' => __('Total')],
            ['data' => 'status', 'name' => 'status', 'label' => __('Status')],
            ['data' => 'payment_status', 'name' => 'payment_status', 'label' => __('Payment Status')],
            ['data' => 'created_at', 'name' => 'created_at', 'label' => __('Created At')],
            ['data' => 'action', 'name' => 'action', 'label' => __('Action')],
        ];
    }

    /*Language Translation*/
    public function lang($locale)
    {
        if ($locale) {

            App::setLocale($locale);
            session()->put('lang', $locale);
            return redirect()->back()->with('locale', $locale);
        } else {
            return redirect()->back();
        }
    }
}
