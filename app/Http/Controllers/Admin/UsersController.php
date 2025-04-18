<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Yajra\DataTables\Facades\DataTables;
use App\Enums\PaymentStatusEnum;

class UsersController extends Controller
{
    public function __construct()
    {
//        $this->middleware('permission:users_list', ['only' => ['index','getData']]);
//        $this->middleware('permission:users_change_status', ['only' => ['changeStatus']]);
    }

    public function index()
    {
        return view('users.list', [
            'columns' => $this->columns()
        ]);
    }

    public function create()
    {
        return view('users.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'city_id' => 'required|exists:cities,id',
            'phone' => 'required|min:7|unique:users,phone',
            'discount' => 'required|numeric|min:0|max:100',
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()],
        ]);
        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator->validated());
        }
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'city_id' => $request->city_id,
            'discount' => $request->discount,
            'password' => $request->password,
        ]);
        session()->flash('success', __('Operation Done Successfully'));
        return redirect()->back();
    }

    public function edit($id)
    {
        $data = User::findOrFail($id);
        return view('users.edit', [
            'data' => $data,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|min:7|unique:users,phone,' . $id,
            'city_id' => 'required|exists:cities,id',
            'discount' => 'required|numeric|min:0|max:100',
            'password' => ['nullable', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()],
        ]);
        $inputs = $validator->validated();
        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($inputs);
        }
        $user = User::findOrFail($id);
        if(!isset($request->password)){
            unset($inputs['password']);
        }
        $user->update($inputs);
        session()->flash('success', __('Operation Done Successfully'));
        return redirect()->back();
    }

    public function show($id)
    {
        $data = User::whereId($id)->first();
        $columns = $this->orders_columns();
        return view('users.show', compact('data', 'columns'));
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
            ->addColumn('name', function ($row) {
                return $row->name;
            })
            ->editColumn('phone', function ($row) {
                return str_replace('+', '', $row->country_code) . $row->phone;
            })
            ->editColumn('email', function ($row) {
                return $row->email ?? '-';
            })
            ->editColumn('is_active', function ($row) {
                $isChecked = $row->is_active ? 'checked' : '';

                return '
                    <div class="form-check form-switch form-switch-right form-switch-md">
                        <input class="form-check-input switch-status" data-id="' . $row->id . '" name="is_active" value="1" type="checkbox" ' . $isChecked . ' id="input-group-showcode">
                    </div>
                ';
            })
            ->addColumn('action', function ($row) {
                $actionButtons = '
                    <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="'.__('Edit').'">
                        <a href="'.route('users.edit',$row->id).'" class="text-primary d-inline-block edit-item-btn">
                            <i class="ri-pencil-fill fs-16"></i>
                        </a>
                    </li>
                ';
//                $actionButtons = '
//                        <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="'.__('Remove').'">
//                            <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" data-model-id="'.$row->id.'" href="#deleteRecordModal">
//                                <i class="ri-delete-bin-5-fill fs-16"></i>
//                            </a>
//                        </li>
//                    ';
                $actionButtons .= '
                    <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="' . __('translation.Show') . '">
                        <a href="' . route('users.show', $row->id) . '" class="text-primary d-inline-block edit-item-btn">
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

//            ->editColumn('created_at', function ($row) {
//                return Carbon::parse($row->created_at)->toDateString();
//            })
            ->rawColumns(['is_active', 'action'])
            ->make();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getOrdersData(Request $request, $user_id)
    {
        return DataTables::eloquent($this->filterOrder($request, $user_id))
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
        $usersQuery = User::query()->orderBy('id', 'desc')
            ->where('manual_deleted', 0)
            ->when($request->has('search_key') && $request->filled('search_key'), function ($query) use ($request) {
                $searchKey = $request->search_key;
                return $query->where(function ($query) use ($searchKey) {
                    $query->whereRaw("name LIKE '%$searchKey%'")
                        ->orWhere('email', 'like', "%$searchKey%")
                        ->orWhereRaw("CONCAT(country_code, phone) LIKE '%$searchKey%'");
                });
            })
            ->when($request->has('from_date') && $request->filled('from_date'), function ($query) use ($request) {
                $query->where('created_at', '>=', $request->from_date);
            })
            ->when($request->has('to_date') && $request->filled('to_date'), function ($query) use ($request) {
                $query->where('created_at', '<=', $request->to_date);
            })
            ->when($request->has('status') && $request->filled('status'), function ($query) use ($request) {
                if (in_array($request->status, [0, 1])) {
                    $query->where('is_active', $request->status);
                }
            })
            ->when($request->has('foods_hsasia') && $request->filled('foods_hsasia'), function ($query) use ($request) {
                if (in_array($request->foods_hsasia, [0, 1])) {
                    if ($request->foods_hsasia == 1) {
                        $query->whereHas('foods');
                    } else {
                        $query->doesntHave('foods');
                    }
                }
            });

        return $usersQuery;
    }

    /**
     * @param Request $request
     * @return Builder
     */
    public function filterOrder(Request $request, $user_id)
    {
        $UserPlansQuery = Order::query()
//        where('payment_status',PaymentStatusEnum::PAID->value)
            ->where(function ($q) use ($user_id) {
                $q->where('user_id', $user_id);
            })
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

        return $UserPlansQuery->with('user');
    }

    public function changeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
            'is_active' => 'required|in:0,1',
        ]);

        if (!is_array($validator) && $validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()]);
        }

        $user = User::findOrFail($request->id);
        $user->is_active = $request->is_active;
        $user->save();
        return response()->json(['success' => __('Operation Done Successfully')]);
    }

    public function columns(): array
    {
        return [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['data' => 'name', 'name' => 'name', 'label' => "الاسم"],
            ['data' => 'phone', 'name' => 'phone', 'label' => __('Phone')],
            ['data' => 'email', 'name' => 'email', 'label' => __('Email')],
//            ['data' => 'created_at', 'name' => 'created_at', 'label' => __('Created At')],
            ['data' => 'is_active', 'name' => 'is_active', 'label' => __('Active')],
            ['data' => 'action', 'name' => 'action', 'label' => __('Action')],
        ];
    }

    public function orders_columns()
    {
        return [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['data' => 'order_number', 'name' => 'order_number', 'label' => 'رقم الطلب'],
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
