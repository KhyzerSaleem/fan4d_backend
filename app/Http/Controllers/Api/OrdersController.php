<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\CancelOrderRequest;
use App\Http\Requests\Api\User\ExecutePayRequest;
use App\Http\Requests\Api\User\OrderApplyVoucherRequest;
use App\Http\Requests\Api\User\OrderComplainRequest;
use App\Http\Requests\Api\User\OrderDetailsRequest;
use App\Http\Requests\Api\User\OrderIndexRequest;
use App\Http\Requests\Api\User\OrderPlaceRequest;
use App\Http\Requests\Api\User\OrderRateRequest;
use App\Http\Resources\Api\User\CartResources;
use App\Http\Resources\Api\User\OrderDetailsResources;
use App\Http\Resources\Api\User\OrderResources;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemDesign;
use App\Models\OrderItemOption;
use App\Models\ProductAttributeOption;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserPoint;
use App\Models\Voucher;
use App\Models\VoucherUser;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class OrdersController extends Controller
{
    protected $targetRepo;


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(OrderIndexRequest $request): JsonResponse
    {
        $inputs = $request->validated();
        $orders = Order::when($inputs['type'] == 'current', function ($q) {
            $q->whereIn('status', ['pending', 'in_progress']);
        })->when($inputs['type'] == 'previous', function ($q) {
            $q->whereIn('status', ['complete', 'cancelled']);
        })->where('user_id', user_id())->orderBy('id', 'desc')->paginate(10);
        $result = (OrderResources::collection($orders))->response()->getData(true);
        return msgdata(true, trans('lang.success'), $result, ResponseAlias::HTTP_OK);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function executePay(ExecutePayRequest $request): JsonResponse
    {
        $request = $request->validated();
        $order = Order::where('id', $request['id'])->where('user_id', user_id())->first();
        if ($order->remain == 0) {
            return msg(false, trans('lang.not_possible_remain_amount_equal_zero'), Response::HTTP_NOT_ACCEPTABLE);

        }
        if ($order->remain > $request['pay_amount']) {
            $payment_status = 'partial_paid';
        } elseif ($order->remain <= $request['pay_amount']) {
            $payment_status = 'paid';
        }
        $order->payment_status = $payment_status;
        $order->pay += $request['pay_amount'];
        $order->remain -= $request['pay_amount'];
        $order->payment_method = 'credit';
        $order->save();

        return msg(true, trans('lang.success'), Response::HTTP_OK);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelOrder(CancelOrderRequest $request): JsonResponse
    {
        $request = $request->validated();
        $order = Order::where('id', $request['id'])->where('user_id', user_id())->first();
        if ($order->status != 'pending') {
            return msg(false, trans('lang.not_possible_to_cancel_order'), Response::HTTP_BAD_REQUEST);
        }

        $order->status = 'cancelled';
        $order->save();

        return msg(true, trans('lang.cancelled_success'), Response::HTTP_OK);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function details(OrderDetailsRequest $request): JsonResponse
    {
        $request = $request->validated();
        $order = Order::where('id', $request['id'])->where('user_id', user_id())->first();
        $result = (new OrderDetailsResources($order));
        return msgdata(true, trans('lang.success'), $result, Response::HTTP_OK);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function applyVoucher(OrderApplyVoucherRequest $request): JsonResponse
    {
        $request = $request->validated();
        $today = Carbon::now();
        $voucher = Voucher::active()->where('code', $request['voucher_code'])->where('use_count', '>', 0)->where('start_date', '<=', $today)->where('expire_date', '>=', $today)->first();
        if ($voucher) {
            //check reaching user the number of voucher users use ...
            $user_used_count = VoucherUser::where('user_id', user_id())->where('voucher_id', $voucher->id)->count();
            if ($user_used_count >= $voucher->user_use_count) {
                return msg(false, trans('lang.voucher_reach_one_user_used'), ResponseAlias::HTTP_NOT_ACCEPTABLE);
            }
            //End Check

            $price_before_tax = $request['total'];
            $tax = settings("tax_percent") ?? 0;
            $product_tax = ($price_before_tax * $tax / 100);
            $final_total = $request['total'] + $product_tax;

            if ($voucher->voucher_used_count < $voucher->use_count) {
                $discount_amount = ($voucher->percent / 100) * $final_total;
                $data['sub_total'] = round($request['total'], 2);
                $data['tax'] = round($product_tax, 2);
                $data['percent'] = round($voucher->percent, 2);
                $data['discount'] = round($discount_amount, 2);
                $data['total'] = round($final_total - $discount_amount, 2);
                return msgdata(true, trans('lang.success'), $data, ResponseAlias::HTTP_OK);
            } else {
                return msg(false, trans('lang.voucher_reach_user_used'), ResponseAlias::HTTP_NOT_ACCEPTABLE);
            }
        } else {
            return msg(false, trans('lang.voucher_not_found'), ResponseAlias::HTTP_NOT_ACCEPTABLE);
        }


    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function place(OrderPlaceRequest $request): JsonResponse
    {

        $request = $request->validated();
        $userId = user_id();
        $user = User::whereId($userId)->first();

//        Calculate cart total
        $address = Address::where('id',$request['address_id'])->first();
        $shipping_cost = $address->Area->cost ;
        $cart = Cart::with('designs', 'options')->where('user_id', user_id())->get();
        $cart_resource = CartResources::collection($cart);
        $total = collect($cart_resource)->sum(fn($item) => $item->price);

//check cart has items
        if (count($cart) == 0) {
            return msg(false, trans('lang.should_add_items_in_cart'), ResponseAlias::HTTP_BAD_REQUEST);
        }

        $price_before_tax = $total;
        $tax = settings("tax_percent") ?? 0;
        $product_tax = ($price_before_tax * $tax / 100);

        $request['order_number'] = Carbon::now()->year . '000' . Order::max('id') + 1;
        $request['user_id'] = user_id();
        $request['sub_total'] = $total;  // add here cart total before tax and discount .
        $request['tax'] = $product_tax;
        $request['shipping_cost'] = $shipping_cost;
        $request['discount'] = 0;
        $final_total = $total + $product_tax + $shipping_cost ;
        $request['total'] = number_format($final_total, 2, '.', '');
        $voucher_added = false;
        if (isset($request['voucher_code'])) {

            $today = Carbon::now();
            $voucher = Voucher::active()->where('code', $request['voucher_code'])->where('use_count', '>', 0)->where('start_date', '<=', $today)->where('expire_date', '>=', $today)->first();
            if ($voucher) {
                //check reaching user the number of voucher users use ...
                $user_used_count = VoucherUser::where('user_id', user_id())->where('voucher_id', $voucher->id)->count();
                if ($user_used_count >= $voucher->user_use_count) {
                    return msg(false, trans('lang.voucher_reach_one_user_used'), ResponseAlias::HTTP_NOT_ACCEPTABLE);
                }
                //End Check
                if ($voucher->voucher_used_count < $voucher->use_count) {
                    $discount_amount = ($voucher->percent / 100) * $final_total;
                    $voucher_added = true;
                    $request['discount'] = $discount_amount;
                    $request['total'] = $final_total - $discount_amount;
                } else {
                    return msg(false, trans('lang.voucher_reach_user_used'), ResponseAlias::HTTP_NOT_ACCEPTABLE);
                }
            } else {
                return msg(false, trans('lang.voucher_not_found'), ResponseAlias::HTTP_NOT_ACCEPTABLE);
            }
        }

        //check wallet balance
        if ($request['payment_method'] == 'wallet') {
            if ($request['total'] > $user->money) {
                return msg(false, trans('lang.you not have enough money in your wallet to use'), ResponseAlias::HTTP_NOT_ACCEPTABLE);
            }
        }

        $order = Order::create($request);

        if ($order) {
//            save order items
            foreach ($cart as $item) {
                $order_item_data['order_id'] = $order->id;
                $order_item_data['product_id'] = $item->product_id;
                $order_item_data['count'] = $item->quantity;
                $order_item_data['quantity'] = $item->quantity;
                $order_item_data['price'] = $item->price;

                $order_item = OrderItem::create($order_item_data);
                foreach ($item->options as $option) {
                    $selected_option = ProductAttributeOption::whereId($option->option->id)->first();
                    $order_item_option_data['order_item_id'] = $order_item->id;
                    $order_item_option_data['product_attribute_option_id'] = $option->option->id;
                    $order_item_option_data['price'] = $selected_option->price;
                    OrderItemOption::create($order_item_option_data);
                }
                foreach ($item->designs as $design) {
                    $order_item_design_data['order_item_id'] = $order_item->id;
                    $order_item_design_data['file'] = basename($design->file);
                    OrderItemDesign::create($order_item_design_data);
                }

            }
            //remove money from user if used wallet
            if ($request['payment_method'] == 'wallet') {
                $user->money -= $request['total'];
                $user->save();

            }
            //calculate user points

            $order_money = settings('order_money');
            $order_points = settings('order_points');

            $avg_reward = $order->total / $order_money;
            $points = $avg_reward * $order_points;
            $user = User::whereId($userId)->first();
            $user->points += $points;
            $user->save();

            //save user points transactions ...
            $user_point_transactions['user_id'] = user_id();
            $user_point_transactions['order_id'] = $order->id;
            $user_point_transactions['points'] = $points;
            $user_point_transactions['type'] = 'add';
            $user_point_transactions['money'] = $order->total;
            UserPoint::create($user_point_transactions);

//            remove all items in cart after order
            Cart::where('user_id', $userId)->delete();
            if ($voucher_added) {
                $voucher_user_data['user_id'] = user_id();
                $voucher_user_data['voucher_id'] = $voucher->id;
                VoucherUser::create($voucher_user_data);

                $voucher->voucher_used_count = $voucher->voucher_used_count + 1;
                $voucher->save();
            }
        }

        return msgdata(true, trans('lang.order_added_s'), $order, ResponseAlias::HTTP_OK);
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function rate(OrderRateRequest $request): JsonResponse
    {
        $request = $request->validated();
        Order::where('id', $request['id'])
            ->orderBy('id', 'desc')
            ->update($request);

        return msg(true, trans('lang.rate_added_s'), Response::HTTP_OK);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function complain(OrderComplainRequest $request): JsonResponse
    {
        $request = $request->validated();
        Order::where('id', $request['id'])
            ->orderBy('id', 'desc')
            ->update($request);

        return msg(true, trans('lang.complain_added_s'), Response::HTTP_OK);
    }


}
