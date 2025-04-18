<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\User\NotificationResources;
use App\Http\Resources\Api\User\VoucherResources;
use App\Models\Notification;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class SettingsController
 * @package App\Http\Controllers\Api
 */
class CouponsController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $today = Carbon::now();
        $data = Voucher::active()
            ->whereDoesntHave('users', function ($q) {
                $q->where('user_id', user_id());
            })
            ->where('use_count', '>', 0)
            ->where('start_date', '<=', $today)
            ->where('expire_date', '>=', $today)
            ->where(function ($q) {
                $q->where('type', 'general')->orWhere('user_id', user_id());
            })
            ->paginate(Config('app.paginate'));


        $data = VoucherResources::collection($data)->response()->getData(true);

        return msgdata(true, trans('lang.success'), $data, Response::HTTP_OK);

    }

}
