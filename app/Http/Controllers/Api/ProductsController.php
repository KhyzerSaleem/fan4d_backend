<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\CalculatePriceRequest;
use App\Http\Resources\Api\User\ProductDetailsResources;
use App\Http\Resources\Api\User\ProductResources;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeOption;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class ProductsController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $products = Product::active()
            ->when($request->search, function ($q) use ($request) {
                $q->where('title_ar', 'like', '%' . $request->search . '%')
                    ->orWhere('title_en', 'like', '%' . $request->search . '%');
            })
            ->when($request->price_sort, function ($w) use ($request) {
                $w->orderBy('price', $request->price_sort);
            })
            ->when($request->category_id, function ($w) use ($request) {
                $w->where('category_id', $request->category_id);
            })
            ->paginate(Config('app.paginate'));
        $data = ProductResources::collection($products)->response()->getData(true);
        return msgdata(true, trans('lang.success'), $data, ResponseAlias::HTTP_OK);
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): JsonResponse
    {
        $product = Product::active()->whereId($id)->firstOrFail();
        $data['product'] = new ProductDetailsResources($product);

        return msgdata(true, trans('lang.success'), $data, ResponseAlias::HTTP_OK);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculatePrice(CalculatePriceRequest $request): JsonResponse
    {
        $inputs = $request->validated();
        $product = Product::whereId($inputs['product_id'])->first();
        $price = $product->price;
        if (isset($inputs['options_selected'])) {
            foreach ($inputs['options_selected'] as $key => $row) {
                $option = ProductAttributeOption::whereId($row)->first();
                $price += $option->price;
            }
        }
        $price = $price * $inputs['quantity'];
        $price = $price * $inputs['count'];
        $data = $price;

        return msgdata(true, trans('lang.success'), $data, ResponseAlias::HTTP_OK);
    }


}
