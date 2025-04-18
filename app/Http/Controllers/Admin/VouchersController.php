<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class VouchersController extends Controller
{
    public function index()
    {
        return view('vouchers.list', [
            'columns' => $this->columns()
        ]);
    }

    public function create()
    {
        return view('vouchers.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
//            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title_ar' => 'required|min:3',
            'title_en' => 'required|min:3',
//            'desc_ar' => 'nullable|max:3000',
//            'desc_en' => 'nullable|max:3000',
            'code' => 'required|min:3|unique:vouchers',
            'start_date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'expire_date' => 'required|date_format:Y-m-d|after_or_equal:start_date',
            'user_use_count' => 'required|integer|min:1',
            'use_count' => 'required|integer|min:1',
            'percent' => 'required|integer|min:0.1',
            'min_order_price' => 'required|numeric|min:0',
        ]);

        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator->validated());
        }

        Voucher::create([
//            'image' => $request->image,
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_en,
//            'desc_ar' => $request->desc_ar,
//            'desc_en' => $request->desc_en,
            'code' => $request->code,
            'start_date' => $request->start_date,
            'expire_date' => $request->expire_date,
            'user_use_count' => $request->user_use_count,
            'use_count' => $request->use_count,
            'min_order_price' => $request->min_order_price,
            'percent' => $request->percent,
//            'for_first_order' => $request->has('for_first_order'),
            'is_active' => $request->has('is_active'),
        ]);

        session()->flash('success', __('Operation Done Successfully'));
        return redirect()->back();
    }

    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('vouchers.edit', compact('voucher'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title_ar' => 'required|min:3',
            'title_en' => 'required|min:3',
//            'desc_ar' => 'nullable|max:3000',
//            'desc_en' => 'nullable|max:3000',
//            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'code' => ['required', 'min:3', Rule::unique('vouchers')->ignore($id)],
            'start_date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'expire_date' => 'required|date_format:Y-m-d|after_or_equal:start_date',
            'user_use_count' => 'required|integer|min:1',
            'use_count' => 'required|integer|min:1',
            'percent' => 'required|integer|min:0.1',
            'min_order_price' => 'required|numeric|min:0',

        ]);

        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator->validated());
        }

        $voucher = Voucher::findOrFail($id);

        $voucher->update([
//            'image' => $request->image,
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_en,
//            'desc_ar' => $request->desc_ar,
//            'desc_en' => $request->desc_en,
            'code' => $request->code,
            'start_date' => $request->start_date,
            'expire_date' => $request->expire_date,
            'user_use_count' => $request->user_use_count,
            'use_count' => $request->use_count,
            'min_order_price' => $request->min_order_price,
            'percent' => $request->percent,
//            'for_first_order' => $request->has('for_first_order'),
            'is_active' => $request->has('is_active'),
        ]);

        session()->flash('success', __('Operation Done Successfully'));
        return redirect()->route('vouchers.index');
    }

    public function destroy($id)
    {
        try {
            $voucher = Voucher::findOrFail($id);
            $voucher->delete();
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
                'ids.*' => 'required|integer|exists:vouchers,id',
            ]);
            if (!is_array($validator) && $validator->fails()) {
                return redirect()->back()->withErrors($validator->validated());
            }
            Voucher::whereIn('id', $ids)->delete();

        } catch (\Exception $e) {
            session()->flash('error', __('Can Not Delete Item Because of it\'s dependency'));
            return redirect()->back();
        }
        session()->flash('success', __('Operation Done Successfully'));
        return redirect()->back();
    }

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
            ->editColumn('for_first_order', function ($row) {
                $isChecked = $row->for_first_order ? 'checked' : '';

                return '
                    <div class="form-check form-switch form-switch-right form-switch-md">
                        <input class="form-check-input switch-for-first-order" data-id="' . $row->id . '" name="for_first_order" value="1" type="checkbox" ' . $isChecked . ' id="input-group-showcode">
                    </div>
                ';
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
                    <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="' . __('Edit') . '">
                        <a href="' . route('vouchers.edit', $row->id) . '" class="text-primary d-inline-block edit-item-btn">
                            <i class="ri-pencil-fill fs-16"></i>
                        </a>
                    </li>
                ';
                $actionButtons .= '
                        <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="' . __('Remove') . '">
                            <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" data-model-id="' . $row->id . '" href="#deleteRecordModal">
                                <i class="ri-delete-bin-5-fill fs-16"></i>
                            </a>
                        </li>
                    ';
                return '
                    <ul class="list-inline hstack gap-2 mb-0">
                        ' . $actionButtons . '
                    </ul>
                ';
            })
            ->editColumn('start_date', function ($row) {
                return Carbon::parse($row->start_date)->toDateString();
            })
            ->editColumn('expire_date', function ($row) {
                return Carbon::parse($row->expire_date)->toDateString();
            })
            ->rawColumns(['select', 'for_first_order', 'is_active', 'action'])
            ->make();
    }

    /**
     * @param Request $request
     * @return Builder
     */
    public function filter(Request $request)
    {
        $vouchersQuery = Voucher::query()
            ->where('type','general')
            ->when($request->has('search_key') && $request->filled('search_key'), function ($query) use ($request) {
                $searchKey = $request->search_key;
                return $query->where(function ($query) use ($searchKey) {
                    $query->where('code', 'like', "%$searchKey%");
                });
            })
            ->when($request->has('from_date') && $request->filled('from_date'), function ($query) use ($request) {
                $query->where('start_date', '>=', $request->from_date);
            })
            ->when($request->has('to_date') && $request->filled('to_date'), function ($query) use ($request) {
                $query->where('expire_date', '<=', $request->to_date);
            })
            ->when($request->has('status') && $request->filled('status'), function ($query) use ($request) {
                if (in_array($request->status, [0, 1])) {
                    $query->where('is_active', $request->status);
                }
            });

        return $vouchersQuery;
    }

    public function changeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:vouchers,id',
            'is_active' => 'required|in:0,1',
        ]);

        if (!is_array($validator) && $validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()]);
        }

        $voucher = Voucher::findOrFail($request->id);
        $voucher->is_active = $request->is_active;
        $voucher->save();
        return response()->json(['success' => __('Operation Done Successfully')]);
    }

    public function changeFirstOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:vouchers,id',
            'for_first_order' => 'required|in:0,1',
        ]);

        if (!is_array($validator) && $validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()]);
        }

        $voucher = Voucher::findOrFail($request->id);
        $voucher->for_first_order = $request->for_first_order;
        $voucher->save();
        return response()->json(['success' => __('Operation Done Successfully')]);
    }

    public function columns(): array
    {
        return [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['data' => 'select', 'name' => 'select', 'orderable' => false, 'searchable' => false],
            ['data' => 'code', 'name' => 'code', 'label' => __('Voucher Code')],
            ['data' => 'start_date', 'name' => 'start_date', 'label' => __('Start Date')],
            ['data' => 'expire_date', 'name' => 'expire_date', 'label' => __('Expire Date')],
            ['data' => 'user_use_count', 'name' => 'user_use_count', 'label' => __('User Use Count')],
            ['data' => 'use_count', 'name' => 'use_count', 'label' => __('Use Count')],
            ['data' => 'voucher_used_count', 'name' => 'voucher_used_count', 'label' => __('Used Count')],
            ['data' => 'percent', 'name' => 'percent', 'label' => __('Percent')],
            ['data' => 'is_active', 'name' => 'is_active', 'label' => __('Active')],
            ['data' => 'action', 'name' => 'action', 'label' => __('Action')],
        ];
    }
}
