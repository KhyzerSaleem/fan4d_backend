<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Slider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SlidersController extends Controller
{
    public function __construct()
    {
//        $this->middleware('permission:sliders_list', ['only' => ['index','getData']]);
//        $this->middleware('permission:sliders_create', ['only' => ['create','store']]);
//        $this->middleware('permission:sliders_update', ['only' => ['edit','update']]);
//        $this->middleware('permission:sliders_delete', ['only' => ['destroy','bulkDelete']]);
//        $this->middleware('permission:sliders_change_status', ['only' => ['changeStatus']]);
    }

    public function index()
    {
        return view('sliders.list', [
            'columns' => $this->columns()
        ]);
    }

    public function create()
    {
//        $products = Product::all();
//        $services = Service::all();
        return view('sliders.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
//            'type' => 'required|in:url,product,service',
//            'product_id' => 'required_if:type,product|exists:products,id',
//            'service_id' => 'required_if:type,service|exists:services,id',
//            'url' => 'required_if:type,url',
            'title_ar' => 'required|max:255',
            'title_en' => 'required|max:255',
            'desc_ar' => 'nullable|max:3000',
            'desc_en' => 'nullable|max:3000',
            'image' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator->validated());
        }

        Slider::create([
//            'type' => $request->type,
//            'product_id' => $request->product_id,
//            'service_id' => $request->service_id,
//            'url' => $request->url,
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_en,
            'desc_ar' => $request->desc_ar,
            'desc_en' => $request->desc_en,
            'image' => $request->image,
            'is_active' => $request->has('is_active'),
        ]);

        session()->flash('success', __('Operation Done Successfully'));
        return redirect()->back();
    }

    public function edit($id)
    {
//        $products = Product::all();
//        $services = Service::all();
        $slider = Slider::findOrFail($id);
        return view('sliders.edit', compact('slider'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title_ar' => 'required|max:255',
            'title_en' => 'required|max:255',
            'desc_ar' => 'nullable|max:3000',
            'desc_en' => 'nullable|max:3000',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator->validated());
        }

        $slider = Slider::findOrFail($id);

        $slider->update([
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_en,
            'desc_ar' => $request->desc_ar,
            'desc_en' => $request->desc_en,
            'image' => $request->image,
            'is_active' => $request->has('is_active'),
        ]);

        session()->flash('success', __('Operation Done Successfully'));
        return redirect()->route('sliders.index');
    }

    public function destroy($id)
    {
        try {
            $slider = Slider::findOrFail($id);
            $slider->delete();
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
                'ids.*' => 'required|integer|exists:sliders,id',
            ]);
            if (!is_array($validator) && $validator->fails()) {
                return redirect()->back()->withErrors($validator->validated());
            }

            Slider::whereIn('id', $ids)->delete();
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
                    <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="' . __('translation.Edit') . '">
                        <a href="' . route('sliders.edit', $row->id) . '" class="text-primary d-inline-block edit-item-btn">
                            <i class="ri-pencil-fill fs-16"></i>
                        </a>
                    </li>
                ';
                $actionButtons .= '
                        <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="' . __('translation.Remove') . '">
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
            ->editColumn('image', function ($row) {
                return '
                    <div class="avatar-sm bg-light rounded p-1 me-2">
                        <img src="' . $row->image . '" alt="" class="img-fluid d-block" />
                    </div>
                ';
            })
            ->rawColumns(['select', 'is_active', 'image', 'action'])
            ->make();
    }

    /**
     * @param Request $request
     * @return Builder
     */
    public function filter(Request $request)
    {
        $sliderQuery = Slider::query()
            ->orderBy('id', 'desc')
            ->when($request->has('search_key') && $request->filled('search_key'), function ($query) use ($request) {
                $searchKey = $request->search_key;
                return $query->where(function ($query) use ($searchKey) {
                    $query->where('title_ar', 'like', "%$searchKey%")
                        ->orWhere('title_en', 'like', "%$searchKey%");
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
            });

        return $sliderQuery;
    }

    public function changeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:sliders,id',
            'is_active' => 'required|in:0,1',
        ]);

        if (!is_array($validator) && $validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()]);
        }

        $slider = Slider::findOrFail($request->id);
        $slider->is_active = $request->is_active;
        $slider->save();
        return response()->json(['success' => __('translation.Operation Done Successfully')]);
    }

    public function columns(): array
    {
        return [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['data' => 'select', 'name' => 'select', 'orderable' => false, 'searchable' => false],
            ['data' => 'image', 'name' => 'image', 'label' => __('Image')],
//            ['data' => 'product_title', 'name' => 'product_title', 'label' => __('Product')],
//            ['data' => 'service_title', 'name' => 'service_title', 'label' => __('Service')],
//            ['data' => 'url', 'name' => 'url', 'label' => __('URL')],
            ['data' => 'is_active', 'name' => 'is_active', 'label' => __('Active')],
            ['data' => 'action', 'name' => 'action', 'label' => __('Action')],
        ];
    }

}
