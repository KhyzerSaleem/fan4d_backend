<?php

namespace App\Http\Controllers\Admin;

use App\Enums\NotificationActionEnum;

use App\Enums\OrderStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class OrdersController extends Controller
{


    public function index()
    {
        return view('orders.list', [
            'columns' => $this->columns()
        ]);
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('orders.show', [
            'title' => 'تفاصيل الطلب',
            'order' => $order
        ]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getData(Request $request)
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
                if ($row->status == OrderStatusEnum::PENDING->value) {
                    $class = "bg-warning-subtle text-warning";
                } elseif ($row->status == OrderStatusEnum::IN_PROGRESS->value) {
                    $class = "bg-primary-subtle text-primary";
                } elseif ($row->status == OrderStatusEnum::COMPLETE->value) {
                    $class = "bg-success-subtle text-success";
                } else {
                    $class = "bg-danger-subtle text-danger";
                }
                return '<span class="badge ' . $class . ' text-uppercase"> ' . __($row->status) . ' </span>';
            })
            ->editColumn('payment_method', function ($row) {
                return trans('lang.' . $row->payment_method);
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
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->toDateString();
            })
            ->rawColumns(['select', 'user_name', 'action', 'status', 'payment_status'])
            ->make();
    }

    /**
     * @param Request $request
     * @return Builder
     */
    public function filter(Request $request)
    {
        $Query = Order::query()
            ->orderBy('id', 'desc')
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
            });

        return $Query->with('user');
    }

    public function changeStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => [
                'required',
                Rule::in(Order::STATUS)
            ],
        ]);

        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator->validated());
        }

        $UserPlan = Order::findOrFail($id);
        $UserPlan->status = $request->status;
        $UserPlan->save();

        //send here notification to customer
        try {
            $subject = 'status has been changed for Order num ' . $UserPlan->id;
            $message = "status has been changed for Order num " . $UserPlan->id . 'To ' . $UserPlan->status;

            $subject_ar = 'تم تغيير حالة الطلب رقم ' . $UserPlan->id;
            $message_ar = 'تم تغيير حالة الطلب رقم ' . $UserPlan->id . 'الي ' . __($UserPlan->status);
            $ids = [$UserPlan->user_id];
            Notification::create([
                'title_ar' => $subject_ar,
                'title_en' => $subject,
                'desc_en' => $message,
                'desc_ar' => $message_ar,
                'type' => 'reservation',
                'action' => NotificationActionEnum::Change_status->value,
                'user_type' => 'custom',
                'target_id' => $UserPlan->id,
                'target_type' => Order::class,
                'users' => implode(',', $ids),
            ]);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        session()->flash('success', __('Operation Done Successfully'));
        return redirect()->back();
    }

    public function changeSystemNotes(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'system_notes' => [
                'required'
            ],
        ]);

        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator->validated());
        }
        $order = Order::findOrFail($id);
        $order->system_notes = $request->system_notes;
        $order->save();
        session()->flash('success', __('Operation Done Successfully'));
        return redirect()->back();
    }

    public function invoice($id)
    {
        $UserPlan = Order::findOrFail($id);
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        return view('orders.invoice', [
            'title' => __('UserPlan Invoice'),
            'UserPlan' => $UserPlan,
            'settings' => $settings,
        ]);
    }


    public function columns()
    {
        return [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['data' => 'order_number', 'name' => 'order_number', 'label' => 'رقم الطلب'],
            ['data' => 'user_name', 'name' => 'user_name', 'label' => 'اسم العميل'],
            ['data' => 'quantity', 'name' => 'quantity', 'label' => 'الكمية'],
            ['data' => 'total', 'name' => 'total', 'label' => 'السعر'],
            ['data' => 'status', 'name' => 'status', 'label' => 'الحالة'],
            ['data' => 'payment_method', 'name' => 'payment_method', 'label' => __('Payment Method')],
            ['data' => 'payment_status', 'name' => 'payment_status', 'label' => __('Payment Status')],
            ['data' => 'created_at', 'name' => 'created_at', 'label' => __('Created At')],
            ['data' => 'action', 'name' => 'action', 'label' => __('Action')],
        ];
    }
}
