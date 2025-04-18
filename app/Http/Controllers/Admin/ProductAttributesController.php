<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductImage;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class ProductAttributesController extends Controller
{
    public function __construct()
    {
//        $this->middleware('permission:products_list', ['only' => ['index','getData']]);
//        $this->middleware('permission:products_create', ['only' => ['create','store']]);
//        $this->middleware('permission:products_update', ['only' => ['edit','update']]);
//        $this->middleware('permission:products_delete', ['only' => ['destroy','bulkDelete']]);
//        $this->middleware('permission:products_change_status', ['only' => ['changeStatus']]);
    }

    public function index(Request $request)
    {
        return view('product_attributes.list', [
            'id' => $request->id,
            'columns' => $this->columns()
        ]);
    }

    public function create(Request $request)
    {
        $ids = ProductAttribute::where('product_id', $request->id)->get()->pluck('attribute_id')->toArray();
        $attributes = Attribute::whereNotIn('id', $ids)->get();
        return view('product_attributes.create', [
            'id' => $request->id,
            'attributes' => $attributes,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'attribute_id' => 'required|exists:attributes,id',
            'type' => ['required', Rule::in(ProductAttribute::TYPE)],
        ]);

        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator->validated());
        }
        ProductAttribute::create([
            'product_id' => $request->product_id,
            'attribute_id' => $request->attribute_id,
            'type' => $request->type,
        ]);
        session()->flash('success', __('Operation Done Successfully'));
        return redirect()->back();
    }

    public function edit($id)
    {
        $productAttributes = ProductAttribute::where('product_id', $id)->pluck('attribute_id')->toArray();

        return view('product_attributes.edit', [
            'product' => Product::findOrFail($id),
            'attributes' => Attribute::active()->get(),
            'categories' => Category::all(),
            'productAttributes' => $productAttributes
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'attribute_id' => 'required|exists:attributes,id',
        ]);

        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator->validated());
        }

        $product = ProductAttribute::findOrFail($id);

        $product->update([
            'product_id' => $request->product_id,
            'attribute_id' => $request->attribute_id,
        ]);
//dd($request->attributes);
        // save product attributes
        if ($request->filled('attributes') && is_array($request->attributes)) {
            $product->attributes()->sync($request->attributes);
        }


        // Update product gallery images if provided
        if ($request->filled('imageNames')) {
            $imagesArray = array_filter(explode(',', $request->imageNames));
            foreach ($imagesArray as $image) {
                $product->images()->create(['image' => $image]);
            }
        }


        session()->flash('success', __('Operation Done Successfully'));
        return redirect()->back();
    }

    public function destroy($id)
    {
        try {
            $product = ProductAttribute::findOrFail($id);
            $product->delete();
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
                'ids.*' => 'required|integer|exists:products,id',
            ]);
            if (!is_array($validator) && $validator->fails()) {
                return redirect()->back()->withErrors($validator->validated());
            }
            Product::whereIn('id', $ids)->delete();

        } catch (\Exception $e) {
            session()->flash('error', __('Can Not Delete Item Because of it\'s dependency'));
            return redirect()->back();
        }
        session()->flash('success', __('Operation Done Successfully'));
        return redirect()->back();
    }

    public function bulkChangeStatus(Request $request)
    {
        try {
            $ids = explode(',', $request->ids);
            $validator = Validator::make(['ids' => $ids], [
                'ids' => 'required|array',
                'ids.*' => 'required|integer|exists:products,id',
            ]);
            if (!is_array($validator) && $validator->fails()) {
                return redirect()->back()->withErrors($validator->validated());
            }

            Product::whereIn('id', $ids)->update([
                'is_active' => $request->is_active ?? 0
            ]);

        } catch (\Exception $e) {
            session()->flash('error', __('Can Not Update Item Because of it\'s dependency'));
            return redirect()->back();
        }
        session()->flash('success', __('Operation Done Successfully'));
        return redirect()->back();
    }

    public function getData(Request $request, $id)
    {
        return DataTables::eloquent($this->filter($request, $id))
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionButtons = '';
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
            ->editColumn('type', function ($row) {
                $isChecked = $row->type ? 'checked' : '';
//                $isDisabled = auth()->user()->hasPermission('products_change_status') ? '' : 'disabled';

                return '
                    <div class="form-check form-switch form-switch-lg">
//                        <input class="form-check-input switch-type" data-id="' . $row->id . '" name="is_active" value="1" type="checkbox" ' . $isChecked . '  id="type_' . $row->id . '">
                        <label class="form-check-label" for="type_' . $row->id . '">مطلوبه</label>
                    </div>
                ';
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->toDateString();
            })
            ->addColumn('title', function ($row) {
                return $row->attribute->title;
            })
            ->addColumn('options_btn', function ($data) {
                return view('product_attributes.parts.options_btn', compact('data'));
            })
            ->rawColumns(['select', 'options_btn', 'action','type'])
            ->make();
    }

    /**
     * @param Request $request
     * @return Builder
     */
    public function filter(Request $request, $id)
    {
        $productsQuery = ProductAttribute::query()
            ->withCount('options')
            ->where('product_id', $id)
            ->when($request->has('search_key') && $request->filled('search_key'), function ($query) use ($request) {
                $searchKey = $request->search_key;
                return $query->where(function ($query) use ($searchKey) {
                    $query->where('title_ar', 'like', "%$searchKey%")
                        ->orWhere('title_en', 'like', "%$searchKey%")
                        ->orWhere('sku', 'like', "%$searchKey%");
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

        return $productsQuery->orderBy('id', 'desc');
    }

    public function changeType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:product_attributes,id',
            'is_active' => 'required|in:0,1',
        ]);

        if (!is_array($validator) && $validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()]);
        }

        $product = ProductAttribute::findOrFail($request->id);
        if($request->is_active == 1){
            $type = 'required';
        }else{
            $type = 'optional';
        }
        $product->type = $type;
        $product->save();

        return response()->json(['success' => __('Operation Done Successfully')]);
    }

    public function columns(): array
    {
        return [
            ['data' => 'id', 'name' => 'id', 'orderable' => false, 'searchable' => false],
            ['data' => 'title', 'name' => 'title', 'label' => trans('Title')],
            ['data' => 'type', 'name' => 'type', 'label' => 'نوع الخاصية', 'orderable' => false, 'searchable' => false],
            ['data' => 'options_btn', 'name' => 'options_btn', 'label' => 'خيارات الخاصية', 'orderable' => false, 'searchable' => false],
            ['data' => 'action', 'name' => 'action', 'label' => trans('Action')],
        ];
    }

    public function UploadGallery(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if (!is_array($validator) && $validator->fails()) {
            return response()->json(['error' => true, 'message' => __('Operation Failed')]);
        }
        $fileName = upload($request->image, 'products');

        return response()->json(['success' => true, 'fileName' => $fileName]);
    }

    public function removeGallery(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'image_id' => 'required|exists:product_images,id',
        ]);

        if (!is_array($validator) && $validator->fails()) {
            return response()->json(['error' => true, 'message' => __('Operation Failed')]);
        }
        $image = ProductImage::where('id', $request->image_id)
            ->where('product_id', $request->product_id)
            ->firstOrFail();

        $image->delete();

        return response()->json(['success' => true, 'message' => __('Operation Done Successfully')]);
    }
}
