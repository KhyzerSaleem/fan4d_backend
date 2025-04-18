<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\User\NotificationResources;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class SettingsController
 * @package App\Http\Controllers\Api
 */
class NotificationController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $data = Notification::whereRaw('FIND_IN_SET(?, users)', [user_id()])
            ->orWhere('user_type','all')
            ->orderBy('id','desc')
            ->paginate(Config('app.paginate'));

        $data = NotificationResources::collection($data)->response()->getData(true);

        return msgdata(true, trans('lang.success'), $data, Response::HTTP_OK);

    }

}
