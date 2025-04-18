<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use App\Http\Resources\Api\User\UserPointResources;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Models\UserPoint;
use App\Models\User;

/**
 * Class SettingsController
 * @package App\Http\Controllers\Api
 */
class PointsController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function transactions(): JsonResponse
    {
        $user = User::whereId(user_id())->first();
        $data['points'] = $user->points;
        $data['money'] = $user->money;
        $transactions = UserPoint::where('user_id', user_id())->orderBy('id', 'desc')->paginate(limit());
        $data['transactions'] = UserPointResources::collection($transactions)->response()->getData(true);
        return msgdata(true, trans('lang.success'), $data, ResponseAlias::HTTP_OK);
    }


    /**
     * @param $key
     * @return \Illuminate\Http\JsonResponse
     */
    public function change(): JsonResponse
    {
        $user = User::whereId(user_id())->first();
        $reward_money = settings('reward_money');
        $reward_points = settings('reward_points');

        $points = $user->points;
        if($points == 0){
            return msg(false, trans('lang.you not have enough points to change'), ResponseAlias::HTTP_NOT_ACCEPTABLE);
        }
        $avg_reward = $points / $reward_points;
        $money = $avg_reward * $reward_money;
        $user->money += $money;
        $user->points -=$points;
        $user->save();

        //save user points transactions ...
        $user_point_transactions['user_id'] = user_id();
        $user_point_transactions['points'] = $points;
        $user_point_transactions['type'] = 'change';
        $user_point_transactions['money'] = $money;
        UserPoint::create($user_point_transactions);

        return msg(true, trans('lang.success'), ResponseAlias::HTTP_OK);

    }

}
