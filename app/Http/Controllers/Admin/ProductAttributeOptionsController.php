<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeOption;
use App\Models\ProductImage;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ProductAttributeOptionsController extends Controller
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
        $product_id = ProductAttribute::whereId($request->id)->first()->product_id;
        return view('product_attribute_options.list', [
            'id' => $request->id,
            'product_id' => $product_id,
            'columns' => $this->columns()
        ]);
    }

    public function create(Request $request)
    {
        $product_attribute = ProductAttribute::whereId($request->id)->first();
        $product_id = $product_attribute->product_id;
        $have_image = $product_attribute->attribute->type == 'text with image';
        return view('product_attribute_options.create', [
            'product_id' => $product_id,
            'have_image' => $have_image,
            'id' => $request->id
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_attribute_id' => 'required|exists:product_attributes,id',
            'title_ar' => 'required|string',
            'title_en' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable',
        ]);

        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator->validated());
        }
        ProductAttributeOption::create([
            'product_attribute_id' => $request->product_attribute_id,
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_en,
            'price' => $request->price,
            'image' => $request->image,
        ]);
        session()->flash('success', __('Operation Done Successfully'));
        return redirect()->back();
    }

    public function edit($id)
    {
        $data = ProductAttributeOption::whereId($id)->first();
        $product_id = $data->product_attribute->product_id;
        $have_image = $data->product_attribute->attribute->type == 'text with image';
        return view('product_attribute_options.edit', [
            'product_id' => $product_id,
            'id' => $data->product_attribute_id,
            'have_image' => $have_image,
            'data' => $data,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'product_attribute_id' => 'required|exists:product_attributes,id',
            'title_ar' => 'required|string',
            'title_en' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'required',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator->validated());
        }
        $product = ProductAttributeOption::findOrFail($id);
        $product->update([
            'product_attribute_id' => $request->product_attribute_id,
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_en,
            'price' => $request->price,
            'image' => $request->image,
        ]);
        session()->flash('success', __('Operation Done Successfully'));
        return redirect()->route('product_attribute_options.index', ['id' => $request->product_attribute_id]);
    }

    public function destroy($id)
    {
        try {
            $product = ProductAttributeOption::findOrFail($id);
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
            ProductAttributeOption::whereIn('id', $ids)->delete();

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

            ProductAttributeOption::whereIn('id', $ids)->update([
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
                        <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="' . __('Edit') . '">
                            <a href="' . route('product_attribute_options.edit', $row->id) . '" class="text-primary d-inline-block edit-item-btn">
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
            ->addColumn('title', function ($row) {
                return $row->title;
            })
            ->rawColumns(['select', 'action','image'])
            ->make();
    }

    /**
     * @param Request $request
     * @return Builder
     */
    public function filter(Request $request, $id)
    {
        $productsQuery = ProductAttributeOption::query()
            ->where('product_attribute_id', $id)
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
            ['data' => 'image', 'name' => 'image', 'label' => trans('Image')],
            ['data' => 'title', 'name' => 'title', 'label' => trans('Title')],
            ['data' => 'price', 'name' => 'price', 'label' => 'السعر'],
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
