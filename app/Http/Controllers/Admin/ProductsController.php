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
use Yajra\DataTables\Facades\DataTables;

class ProductsController extends Controller
{
    public function __construct()
    {
//        $this->middleware('permission:products_list', ['only' => ['index','getData']]);
//        $this->middleware('permission:products_create', ['only' => ['create','store']]);
//        $this->middleware('permission:products_update', ['only' => ['edit','update']]);
//        $this->middleware('permission:products_delete', ['only' => ['destroy','bulkDelete']]);
//        $this->middleware('permission:products_change_status', ['only' => ['changeStatus']]);
    }

    public function index()
    {
        return view('products.list', [
            'columns' => $this->columns()
        ]);
    }

    public function create()
    {
        return view('products.create', [
            'attributes' => Attribute::active()->get(),
            'categories' => Category::all()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'desc_ar' => 'nullable|string|max:3000',
            'desc_en' => 'nullable|string|max:3000',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'custom_quantity_from' => 'required|numeric|min:0',
            'custom_quantity_to' => 'required|numeric|min:0|gte:custom_quantity_from',
            'discount' => 'nullable|numeric|min:0|max:100',
            'image' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_names' => 'nullable',
            'attributes' => 'nullable|array',
            'attributes.*' => 'nullable|exists:attributes,id',

            'quantities' => 'required|array',
            'quantities.*' => 'required|numeric|min:0',
        ]);

        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator->validated());
        }

        $product = Product::create([
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_en,
            'desc_ar' => $request->desc_ar,
            'desc_en' => $request->desc_en,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'custom_quantity_from' => $request->custom_quantity_from,
            'custom_quantity_to' => $request->custom_quantity_to,
            'discount' => $request->discount,
            'image' => $request->image,
            'is_active' => $request->has('is_active')
        ]);

        // save product attributes
        if ($request->filled('attributes') && is_array($request['attributes'])) {
            $attributes = collect($request['attributes'])->map(fn($id) => ['attribute_id' => $id]);
            $product->attributes()->createMany($attributes);
        }
        // save product quantities
        if ($request->filled('quantities') && is_array($request['quantities'])) {
            $quantities = collect($request['quantities'])->map(fn($id) => ['quantity' => $id]);
            $product->quantities()->createMany($quantities);
        }
        // save product gallery
        if ($request->filled('image_names')) {
            $imagesArray = array_filter(explode(',', $request->image_names));
            foreach ($imagesArray as $image) {
                $product->images()->create(['image' => $image]);
            }
        }

        session()->flash('success', __('Operation Done Successfully'));
        return redirect()->back();
    }

    public function edit($id)
    {
        $productAttributes = ProductAttribute::where('product_id', $id)->pluck('attribute_id')->toArray();

        return view('products.edit', [
            'product' => Product::findOrFail($id),
            'attributes' => Attribute::active()->get(),
            'categories' => Category::all(),
            'productAttributes' => $productAttributes
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'desc_ar' => 'nullable|string|max:3000',
            'desc_en' => 'nullable|string|max:3000',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'custom_quantity_from' => 'required|numeric|min:0',
            'custom_quantity_to' => 'required|numeric|min:0|gte:custom_quantity_from',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_names' => 'nullable',
            'quantities' => 'required|array',
            'quantities.*' => 'required|numeric|min:0',
        ]);

        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator->validated());
        }

        $product = Product::findOrFail($id);

        $product->update([
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_en,
            'desc_ar' => $request->desc_ar,
            'desc_en' => $request->desc_en,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'discount' => $request->discount,
            'custom_quantity_from' => $request->custom_quantity_from,
            'custom_quantity_to' => $request->custom_quantity_to,
            'image' => $request->image,
            'is_active' => $request->has('is_active')
        ]);

        // Update product gallery images if provided
        if ($request->filled('image_names')) {
            $imagesArray = array_filter(explode(',', $request->image_names));

            foreach ($imagesArray as $image) {
                $product->images()->create(['image' => $image]);
            }
        }
        // save product quantities
        if ($request->filled('quantities') && is_array($request['quantities'])) {
            $product->quantities()->delete();
            $quantities = collect($request['quantities'])->map(fn($id) => ['quantity' => $id]);
            $product->quantities()->createMany($quantities);
        }

        session()->flash('success', __('Operation Done Successfully'));
        return redirect()->back();
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
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
            ->editColumn('price', function ($row) {
                if($row->discount > 0){
                    return '<s>'.$row->price_original.'</s> - '.$row->price . ' ' . trans('SAR');

                }else{
                    return $row->price . ' ' . trans('SAR');

                }
            })
            ->addColumn('category', function ($row) {
                return $row->category->title;
            })
            ->editColumn('is_active', function ($row) {
                $isChecked = $row->is_active ? 'checked' : '';
//                $isDisabled = auth()->user()->hasPermission('products_change_status') ? '' : 'disabled';

                return '
                    <div class="form-check form-switch form-switch-right form-switch-md">
                        <input class="form-check-input switch-status" data-id="' . $row->id . '" name="is_active" value="1" type="checkbox" ' . $isChecked . '  id="input-group-showcode">
                    </div>
                ';
            })
            ->addColumn('action', function ($row) {
                $actionButtons = '';
                $actionButtons .= '
                        <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="' . __('Edit') . '">
                            <a href="' . route('products.edit', $row->id) . '" class="text-primary d-inline-block edit-item-btn">
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
            ->editColumn('image', function ($row) {
                return '
                    <div class="avatar-sm bg-light rounded p-1 me-2">
                        <img src="' . $row->image . '" alt="" class="img-fluid d-block" />
                    </div>
                ';
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->toDateString();
            })

            ->addColumn('attributes_btn', function ($data) {
                return view('products.parts.attributes_btn', compact('data'));
            })
            ->rawColumns(['select', 'image', 'is_active', 'action', 'category','price'])
            ->make();
    }

    /**
     * @param Request $request
     * @return Builder
     */
    public function filter(Request $request)
    {
        $productsQuery = Product::query()
            ->withCount('attributes')
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

    public function changeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:products,id',
            'is_active' => 'required|in:0,1',
        ]);

        if (!is_array($validator) && $validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()]);
        }

        $product = Product::findOrFail($request->id);
        $product->is_active = $request->is_active;
        $product->save();

        return response()->json(['success' => __('Operation Done Successfully')]);
    }

    public function columns(): array
    {
        return [
            ['data' => 'id', 'name' => 'id', 'orderable' => false, 'searchable' => false],
            ['data' => 'select', 'name' => 'select', 'orderable' => false, 'searchable' => false],
            ['data' => 'image', 'name' => 'image', 'label' => trans('Image')],
            ['data' => 'title_' . App::getLocale(), 'name' => 'title_' . App::getLocale(), 'label' => trans('Title')],
            ['data' => 'category', 'name' => 'category', 'label' => 'القسم'],
            ['data' => 'price', 'name' => 'price', 'label' => trans('Price')],
            ['data' => 'attributes_btn', 'name' => 'attributes_btn', 'label' => trans('attributes'), 'orderable' => false, 'searchable' => false],
            ['data' => 'created_at', 'name' => 'created_at', 'label' => trans('Created At')],
            ['data' => 'is_active', 'name' => 'is_active', 'label' => trans('Active')],
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
