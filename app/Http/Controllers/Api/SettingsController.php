<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\ContactUsRequest;
use App\Http\Resources\Api\User\PagesResources;
use App\Http\Resources\Api\User\SettingsResources;
use App\Models\Contact;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * Class SettingsController
 * @package App\Http\Controllers\Api
 */
class SettingsController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function settings(): JsonResponse
    {
        $settings = Setting::get();
        $data = SettingsResources::collection($settings);
        return msgdata(true, trans('lang.success'), $data, Response::HTTP_OK);

    }


    /**
     * @param $key
     * @return \Illuminate\Http\JsonResponse
     */
    public function custom_settings($key): JsonResponse
    {
        $setting = Setting::where('key', $key)->first();
        if (!$setting) {
            return msg(false, trans('lang.page_not_found'), Response::HTTP_NOT_FOUND);
        }

        $data = new SettingsResources($setting);
        return msgdata(true, trans('lang.success'), $data, Response::HTTP_OK);

    }

    /**
     * @param $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function pages($type): JsonResponse
    {

        $page = Page::where('type', $type)->first();
        if (!$page) {
            return msg(false, trans('lang.page_not_found'), Response::HTTP_NOT_FOUND);
        }
        $data = new PagesResources($page);
        return msgdata(true, trans('lang.success'), $data, Response::HTTP_OK);
    }

    /**
     * @param $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function contactUs(ContactUsRequest $request): JsonResponse
    {

        $data = $request->validated();
        Contact::create($data);
        return msg(true, trans('lang.success'), ResponseAlias::HTTP_OK);
    }
}
