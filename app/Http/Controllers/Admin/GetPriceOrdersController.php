<?php

namespace App\Http\Controllers\Admin;

use App\Enums\NotificationActionEnum;

use App\Enums\OrderStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\DirectOrder;
use App\Models\GetPrice;
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

class GetPriceOrdersController extends Controller
{


    public function index()
    {
        return view('get_prices.list', [
            'columns' => $this->columns()
        ]);
    }

    public function show($id)
    {

        $order = GetPrice::findOrFail($id);
        $order->seen_at = Carbon::now();
        $order->save();
        return view('get_prices.edit', [
            'title' => 'تفاصيل طلب الحصول على التسعيرة',
            'data' => $order
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

            ->addColumn('action', function ($row) {
                $actionButtons = '
                    <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="' . __('translation.Show') . '">
                        <a href="' . route('get_prices.show', $row->id) . '" class="text-primary d-inline-block edit-item-btn">
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
            ->addColumn('user_name', function ($row) {
                $user = $row->user->name ? ($row->user->name) : $row->user->phone;
                return '<a href="' . route('users.show', $row->user_id) . '">' . $user . '</a>';
            })
            ->rawColumns(['select', 'action','user_name'])
            ->make();
    }

    /**
     * @param Request $request
     * @return Builder
     */
    public function filter(Request $request)
    {
        $Query = GetPrice::query()
            ->orderBy('id', 'desc')
//        where('payment_status',PaymentStatusEnum::PAID->value)
            ->when($request->has('search_key') && $request->filled('search_key'), function ($query) use ($request) {
                $searchKey = $request->search_key;
                return $query->where(function ($query) use ($searchKey) {
                    $query->where('id', 'like', "%$searchKey%")
                        ->orWhere('sub_total', 'like', "%$searchKey%")
                        ->orWhere('tax', 'like', "%$searchKey%")
                        ->orWhere('total', 'like', "%$searchKey%");
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

    public function reply(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'reply' => [
                'required'
            ],
        ]);

        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator->validated());
        }
        $order = GetPrice::findOrFail($id);
        $order->reply = $request->reply;
        $order->save();
        session()->flash('success', __('Operation Done Successfully'));
        return redirect()->back();
    }



    public function columns()
    {
        return [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['data' => 'user_name', 'name' => 'user_name', 'label' => 'اسم العميل'],
            ['data' => 'subject', 'name' => 'subject', 'label' => 'الموضوع'],
            ['data' => 'created_at', 'name' => 'created_at', 'label' => __('Created At')],
            ['data' => 'action', 'name' => 'action', 'label' => __('Action')],
        ];
    }

    public function destroy($id)
    {
        try {
            $category = DirectOrder::findOrFail($id);
            $category->delete();
        } catch (\Exception $e) {
            session()->flash('error', __('Can Not Delete Item Because of it\'s dependency'));
            return redirect()->back();
        }


        session()->flash('success', __('Operation Done Successfully'));
        return redirect()->back();
    }

    public function bulkDelete(Request $request)
    {
        try {
            $ids = explode(',', $request->ids);
            $validator = Validator::make(['ids' => $ids], [
                'ids' => 'required|array',
                'ids.*' => 'required|integer|exists:get_prices,id',
            ]);
            if (!is_array($validator) && $validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }
            GetPrice::whereIn('id', $ids)->delete();

        } catch (\Exception $e) {
            session()->flash('error', __('Can Not Delete Item Because of it\'s dependency'));
            return redirect()->back();
        }
        session()->flash('success', __('Operation Done Successfully'));
        return redirect()->back();
    }
}
