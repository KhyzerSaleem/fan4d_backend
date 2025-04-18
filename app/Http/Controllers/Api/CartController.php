<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\AddCartRequest;
use App\Http\Requests\Api\User\RemoveCartRequest;
use App\Http\Resources\Api\User\CartResources;
use App\Http\Resources\Api\User\NotificationResources;
use App\Http\Resources\Api\User\VoucherResources;
use App\Models\Cart;
use App\Models\Notification;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * Class SettingsController
 * @package App\Http\Controllers\Api
 */
class CartController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $cart = Cart::with('designs', 'options')->where('user_id', user_id())->get();
        $data['items'] = CartResources::collection($cart);
        $total = collect($data['items'])->sum(fn($item) => $item->price);
        $data['total'] = $total;
        return msgdata(true, trans('lang.success'), $data, ResponseAlias::HTTP_OK);

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function addCart(AddCartRequest $request): JsonResponse
    {
        DB::beginTransaction();
        $inputs = $request->validated();
        $inputs['user_id'] = user_id();
        $cart = Cart::create($inputs);
        if ($cart) {
            if (isset($inputs['options_selected'])) {
                if ($inputs['options_selected'] && is_array($inputs['options_selected'])) {
                    $options = collect($inputs['options_selected'])->map(fn($id) => ['product_attribute_option_id' => $id]);
                    $cart->options()->createMany($options);
                }
            }
            if (isset($inputs['designs'])) {
                if ($inputs['designs'] && is_array($inputs['designs'])) {
                    $options = collect($inputs['designs'])->map(fn($id) => ['file' => $id]);
                    $cart->designs()->createMany($options);
                }
            }
        }
        DB::commit();
        return msg(true, trans('lang.success'), ResponseAlias::HTTP_OK);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeCart(RemoveCartRequest $request): JsonResponse
    {
        DB::beginTransaction();
        $inputs = $request->validated();
        Cart::whereId($inputs['cart_id'])->delete();
        DB::commit();
        return msg(true, trans('lang.success'), ResponseAlias::HTTP_OK);
    }

}
