<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\directOrderRequest;
use App\Http\Requests\Api\User\GetPriceRequest;
use App\Http\Resources\Api\User\ArticleResources;
use App\Http\Resources\Api\User\BranchDetailsResources;
use App\Http\Resources\Api\User\CategoriesResources;
use App\Http\Resources\Api\User\OfferResources;
use App\Http\Resources\Api\User\ProductResources;
use App\Http\Resources\Api\User\ReviewResources;
use App\Http\Resources\Api\User\SlidersResources;
use App\Http\Resources\Api\User\StepsResources;
use App\Models\Article;
use App\Models\Banner;
use App\Models\Branch;
use App\Models\Category;
use App\Models\DirectOrder;
use App\Models\DirectOrderFile;
use App\Models\GetPrice;
use App\Models\GetPriceFile;
use App\Models\Offer;
use App\Models\Page;
use App\Models\Product;
use App\Models\Review;
use App\Models\Slider;
use App\Models\Step;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class HomeController extends Controller
{


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function directOrder(directOrderRequest $request): JsonResponse
    {
        $inputs = $request->validated();

        $order = DirectOrder::create($inputs);
        if ($order) {
            if (isset($inputs['files'])) {
                foreach ($inputs['files'] as $file) {
                    $data['direct_order_id'] = $order->id;
                    $data['file'] = $file;
                    DirectOrderFile::create($data);
                }
            }
        }

        return msg(true, trans('lang.success'), ResponseAlias::HTTP_OK);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPrice(GetPriceRequest $request): JsonResponse
    {
        $inputs = $request->validated();
        $inputs['user_id'] = user_id();
        $order = GetPrice::create($inputs);
        if ($order) {
            if (isset($inputs['files'])) {
                foreach ($inputs['files'] as $file) {
                    $data['get_price_id'] = $order->id;
                    $data['file'] = $file;
                    GetPriceFile::create($data);
                }
            }
        }

        return msg(true, trans('lang.success'), ResponseAlias::HTTP_OK);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function articles(): JsonResponse
    {
        $medical = Article::paginate(20);
        $result = ArticleResources::collection($medical)->response()->getData(true);
        //    most sell service API
        return msgdata(true, trans('lang.success'), $result, ResponseAlias::HTTP_OK);
    }

    public function sliders(): JsonResponse
    {
        $data = Slider::active()->get();
        $result = SlidersResources::collection($data);
        return msgdata(true, trans('lang.success'), $result, ResponseAlias::HTTP_OK);
    }

    public function banners(): JsonResponse
    {
        $data = Banner::active()->get();
        $result = SlidersResources::collection($data);
        return msgdata(true, trans('lang.success'), $result, ResponseAlias::HTTP_OK);
    }

    public function steps(): JsonResponse
    {
        $data = Step::orderBy('id', 'asc')->get();
        $result = StepsResources::collection($data);
        return msgdata(true, trans('lang.success'), $result, ResponseAlias::HTTP_OK);
    }

    public function reviews(): JsonResponse
    {
        $data = Review::active()->orderBy('id', 'asc')->get();
        $result = ReviewResources::collection($data);
        return msgdata(true, trans('lang.success'), $result, ResponseAlias::HTTP_OK);
    }


    public function notPrintProducts(): JsonResponse
    {
        $data = Product::whereHas('category', function ($q) {
            $q->where('type', 'not_printing');
        })->active()->get()->take(8);
        $result = ProductResources::collection($data);
        return msgdata(true, trans('lang.success'), $result, ResponseAlias::HTTP_OK);
    }


    public function offers(): JsonResponse
    {
        $data = Offer::active()->orderBy('id', 'asc')->get();
        $result = OfferResources::collection($data);
        return msgdata(true, trans('lang.success'), $result, ResponseAlias::HTTP_OK);
    }

    public function allOffers(): JsonResponse
    {
        $data = Offer::active()->orderBy('id', 'asc')->paginate(20);
        $result = OfferResources::collection($data)->response()->getData(true);
        return msgdata(true, trans('lang.success'), $result, ResponseAlias::HTTP_OK);
    }

    public function about(): JsonResponse
    {
        $data = Page::whereType('about')->first();
        $result = new SlidersResources($data);
        return msgdata(true, trans('lang.success'), $result, ResponseAlias::HTTP_OK);
    }

    public function categories(): JsonResponse
    {
        $data = Category::orderBy('id', 'asc')->active()->get()->take(7);
        $result = CategoriesResources::collection($data);
        return msgdata(true, trans('lang.success'), $result, ResponseAlias::HTTP_OK);
    }

    public function allCategories(): JsonResponse
    {
        $data = Category::orderBy('id', 'asc')->active()->paginate(20);
        $result = CategoriesResources::collection($data)->response()->getData(true);
        return msgdata(true, trans('lang.success'), $result, ResponseAlias::HTTP_OK);
    }

    public function categoriesByType($type): JsonResponse
    {
        $data = Category::where('type', $type)->orderBy('id', 'asc')->active()->paginate(20);
        $result = CategoriesResources::collection($data)->response()->getData(true);
        return msgdata(true, trans('lang.success'), $result, ResponseAlias::HTTP_OK);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function branchDetails($id): JsonResponse
    {

        $branch = Branch::where('id', $id)->first();
        $result = new BranchDetailsResources($branch);

        //    most sell service API

        return msgdata(true, trans('lang.success'), $result, ResponseAlias::HTTP_OK);
    }


}
