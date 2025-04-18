<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\AddressMakeDefaultRequest;
use App\Http\Requests\Api\User\AddressRequest;
use App\Http\Resources\Api\User\AddressesResources;
use App\Models\Address;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class AddressesController extends Controller
{
    protected $targetRepo;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $data = Address::where('user_id', user_id())
            ->orderBy('id', 'desc')
            ->paginate(Config('app.paginate'));
        $result = (AddressesResources::collection($data))->response()->getData(true);
        return msgdata(true, trans('lang.success'), $result, Response::HTTP_OK);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function details(AddressMakeDefaultRequest $request): JsonResponse
    {
        $request = $request->validated();
        $data = Address::where('user_id', user_id())->where('id', $request['id'])
            ->orderBy('id', 'desc')
            ->first();
        $data = new AddressesResources($data);
        return msgdata(true, trans('lang.success'), $data, Response::HTTP_OK);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AddressRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = user_id();
        $exists_address = Address::where('user_id', user_id())->first();
        if (!$exists_address) {
            $data['is_default'] = 1;
        }
        Address::create($data);
        return msg(true, trans('lang.added_s'), Response::HTTP_OK);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AddressRequest $request)
    {
        $request = $request->validated();
        Address::where('id', $request['id'])->update($request);
        return msg(true, trans('lang.updated_s'), Response::HTTP_OK);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function makeDefault(AddressMakeDefaultRequest $request): JsonResponse
    {
        $request = $request->validated();
        //check if this first address or not
        $exists_address = Address::where('user_id', user_id())->where('id', $request['id'])->first();
        if (!$exists_address) {
            return msg(false, trans('lang.should_choose_your_address'), Response::HTTP_BAD_REQUEST);
        } else {
            Address::where('user_id', user_id())->update(['is_default' => 0]);
            $exists_address->is_default = 1;
            $exists_address->save();
            return msg(true, trans('lang.updated_s'), Response::HTTP_OK);
        }

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(AddressMakeDefaultRequest $request): JsonResponse
    {
        $request = $request->validated();
        try {
            $exists_address = Address::where('user_id', user_id())->where('id', $request['id'])->first();
            if (!$exists_address) {
                return msg(false, trans('lang.should_choose_your_address'), Response::HTTP_BAD_REQUEST);
            } else {
                $exists_address->delete();
                return msg(true, trans('lang.deleted_s'), Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            return msg(false, trans('lang.address_used_in_order_already_cant_delete'), Response::HTTP_BAD_REQUEST);

        }
    }


}
