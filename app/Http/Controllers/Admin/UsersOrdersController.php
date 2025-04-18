<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class UsersOrdersController extends Controller
{
    public function index($userId)
    {
        return view('users.orders.list', [
            'columns' => $this->columns(),
            'userId' => $userId
        ]);
    }

    /**
     * @param Request $request
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getData(Request $request, int $userId)
    {
        return DataTables::eloquent($this->filter($request, $userId))
            ->addIndexColumn()
            ->addColumn('select', function ($row) {
                return '
                    <th scope="row">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="selectedItems[]" value="'.$row->id.'">
                        </div>
                    </th>
                ';
            })
            ->addColumn('user_name', function ($row){
                return $row->user->name ;
            })
            ->editColumn('sub_total', function ($row) {
                return $row->sub_total .' '. __('SAR');
            })
            ->editColumn('tax', function ($row) {
                return $row->tax ? $row->tax .' '. __('SAR') : '-';
            })
            ->editColumn('discount', function ($row) {
                return $row->discount ? $row->discount .' '. __('SAR') : '-';
            })
            ->editColumn('total', function ($row) {
                return $row->total .' '. __('SAR');
            })
            ->editColumn('status', function ($row) {
                if ($row->status == OrderStatusEnum::PENDING->value) {
                    $class = "bg-warning-subtle text-warning";
                }elseif ($row->status == OrderStatusEnum::IN_PROGRESS->value) {
                    $class = "bg-primary-subtle text-primary";
                }elseif ($row->status == OrderStatusEnum::COMPLETE->value) {
                    $class = "bg-success-subtle text-success";
                }else {
                    $class = "bg-danger-subtle text-danger";
                }
                return '<span class="badge ' . $class . ' text-uppercase"> ' . __($row->status) . ' </span>';
            })
            ->editColumn('payment_status', function ($row) {
                if ($row->payment_status == PaymentStatusEnum::PARTIAL_PAID->value) {
                    $class = "bg-primary-subtle text-primary";
                }elseif ($row->payment_status == PaymentStatusEnum::PAID->value) {
                    $class = "bg-success-subtle text-success";
                }else {
                    $class = "bg-warning-subtle text-warning";
                }
                return '<span class="badge ' . $class . ' text-uppercase"> ' . __($row->payment_status) . ' </span>';
            })
            ->addColumn('action', function ($row) {
                $actionButtons = '
                    <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="'.__('translation.Show').'">
                        <a href="'.route('orders.show',$row->id).'" class="text-primary d-inline-block edit-item-btn">
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
            ->rawColumns(['select', 'status', 'payment_status', 'action'])
            ->make();
    }

    /**
     * @param Request $request
     * @param int $userId
     * @return Builder
     */
    public function filter(Request $request, int $userId)
    {
        $ordersQuery = Order::where('user_id',$userId)
            ->when($request->has('search_key') && $request->filled('search_key'), function ($query) use ($request) {
                $searchKey = $request->search_key;
                $query->where('order_number', 'like', "%$searchKey%")
                    ->orWhere('sub_total', 'like', "%$searchKey%")
                    ->orWhere('tax', 'like', "%$searchKey%")
                    ->orWhere('total', 'like', "%$searchKey%");
            })
            ->when($request->has('from_date') && $request->filled('from_date'), function ($query) use ($request) {
                $query->where('created_at','>=',$request->from_date);
            })
            ->when($request->has('to_date') && $request->filled('to_date'), function ($query) use ($request) {
                $query->where('created_at','<=',$request->to_date);
            })
            ->when($request->has('status') && $request->filled('status'), function ($query) use ($request) {
                $query->where('status',$request->status);
            });

        return $ordersQuery->with('user');
    }

    public function columns()
    {
        return [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['data' => 'order_number', 'name' => 'order_number', 'label' => __('Order Number')],
            ['data' => 'user_name', 'name' => 'user_name', 'label' => __('User Name')],
            ['data' => 'sub_total', 'name' => 'sub_total', 'label' => __('Sub Total')],
            ['data' => 'tax', 'name' => 'tax', 'label' => __('Tax')],
            ['data' => 'discount', 'name' => 'discount', 'label' => __('Discount')],
            ['data' => 'total', 'name' => 'total', 'label' => __('Total')],
            ['data' => 'status', 'name' => 'status', 'label' => __('Status')],
            ['data' => 'payment_status', 'name' => 'payment_status', 'label' => __('Payment Status')],
            ['data' => 'created_at', 'name' => 'created_at', 'label' => __('Created At')],
            ['data' => 'action', 'name' => 'action', 'label' => __('Action')],
        ];
    }
}
