<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\AddressMakeDefaultRequest;
use App\Http\Requests\Api\User\AddressRequest;
use App\Http\Requests\Api\User\CarsRequest;
use App\Http\Resources\Api\User\AdditionalMealResources;
use App\Http\Resources\Api\User\AddressesResources;
use App\Http\Resources\Api\User\BrandResources;
use App\Http\Resources\Api\User\CarColorResources;
use App\Http\Resources\Api\User\CategoriesResources;
use App\Http\Resources\Api\User\CountryResources;
use App\Http\Resources\Api\User\DeliveryTimeResources;
use App\Http\Resources\Api\User\FoodsResources;
use App\Http\Resources\Api\User\ModellResources;
use App\Http\Resources\Api\User\PointSettingResources;
use App\Http\Resources\Api\User\ProductionYearResources;
use App\Http\Resources\Api\User\SplashResources;
use App\Models\AdditionalMeal;
use App\Models\Address;
use App\Models\Area;
use App\Models\Brand;
use App\Models\CarColor;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\DeliveryTime;
use App\Models\Food;
use App\Models\Modell;
use App\Models\PointSetting;
use App\Models\ProductionYear;
use App\Models\Setting;
use App\Models\Splash;
use App\Models\UserCar;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class HelpersController extends Controller
{
    protected $targetRepo;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function foods(Request $request): JsonResponse
    {
        $data = Food::active()
            ->orderBy('id', 'desc')
            ->get();
        $result = (FoodsResources::collection($data));
        return msgdata(true, trans('lang.success'), $result, Response::HTTP_OK);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function point_reward_settings(Request $request): JsonResponse
    {
        $data['reward_money'] = Setting::where('key', 'reward_money')->first()->value;
        $data['reward_points'] = Setting::where('key', 'reward_points')->first()->value;
        return msgdata(true, trans('lang.success'), $data, Response::HTTP_OK);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function pointSettings(Request $request): JsonResponse
    {
        $data = PointSetting::active()
            ->orderBy('id', 'desc')
            ->get();
        $result = (PointSettingResources::collection($data));
        return msgdata(true, trans('lang.success'), $result, Response::HTTP_OK);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function additionalMeals(Request $request): JsonResponse
    {
        $data = AdditionalMeal::active()
            ->orderBy('id', 'desc')
            ->get();
        $result = AdditionalMealResources::collection($data);
        return msgdata(true, trans('lang.success'), $result, Response::HTTP_OK);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function splashes(Request $request): JsonResponse
    {
        $data = Splash::active()
            ->orderBy('id', 'asc')
            ->get();
        $result = (SplashResources::collection($data));
        return msgdata(true, trans('lang.success'), $result, Response::HTTP_OK);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function cities(Request $request): JsonResponse
    {
        $data = City::active()
            ->orderBy('id', 'asc')
            ->get();
        $result = (CountryResources::collection($data));
        return msgdata(true, trans('lang.success'), $result, Response::HTTP_OK);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function areas(Request $request, $id): JsonResponse
    {
        $data = Area::where('city_id', $id)->active()
            ->orderBy('id', 'asc')
            ->get();
        $result = (CountryResources::collection($data));
        return msgdata(true, trans('lang.success'), $result, Response::HTTP_OK);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function delivery_times(Request $request): JsonResponse
    {
        $data = DeliveryTime::active()
            ->orderBy('id', 'asc')
            ->get();
        $result = (DeliveryTimeResources::collection($data));
        return msgdata(true, trans('lang.success'), $result, Response::HTTP_OK);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function categories(Request $request): JsonResponse
    {
        $data = Category::active()
            ->orderBy('id', 'desc')
            ->get();
        $result = (CategoriesResources::collection($data));
        return msgdata(true, trans('lang.success'), $result, Response::HTTP_OK);
    }


}
