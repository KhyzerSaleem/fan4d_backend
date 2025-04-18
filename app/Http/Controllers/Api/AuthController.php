<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\AddWishlistRequest;
use App\Http\Requests\Api\User\ForgetPasswordRequest;
use App\Http\Requests\Api\User\ForgetPasswordUpdatePasswordRequest;
use App\Http\Requests\Api\User\SignUpRequest;
use App\Http\Requests\Api\User\VerifyForgetPasswordRequest;
use App\Http\Requests\Api\User\ProfileUpdateRequest;
use App\Http\Requests\Api\User\UserLoginRequest;
use App\Http\Requests\Api\User\verifySignUpRequest;
use App\Http\Resources\Api\User\GetPriceDetailsResources;
use App\Http\Resources\Api\User\GetPriceResources;
use App\Http\Resources\Api\User\ProductResources;
use App\Http\Resources\Api\User\UserResource;
use App\Models\GetPrice;
use App\Models\GetPriceFile;
use App\Models\PasswordResetToken;
use App\Models\Product;
use App\Models\User;
use App\Models\Wishlist;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class AuthController extends Controller
{
    public function login(UserLoginRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return msg(false, trans('Invalid email number or password'), Response::HTTP_UNAUTHORIZED);
        }
        if ($user) {
            if ($user->email_verified_at == null) {
                auth('user')->logout();
                return msg(false, trans('Verify phone first'), Response::HTTP_NOT_ACCEPTABLE);
            }
            if ($user->manual_deleted == 1) {
                auth('user')->logout();
                return msg(false, trans('email not exists please sign up'), Response::HTTP_NOT_ACCEPTABLE);
            }
            if ($user->is_active == 0) {
                auth('user')->logout();
                return msg(false, trans('lang.your_account_is_not_active'), Response::HTTP_NOT_ACCEPTABLE);
            }
        } else {
            return msg(false, trans('email not exists please sign up'), Response::HTTP_NOT_ACCEPTABLE);
        }
        $remember = $request->has('remember') ? true : false;
        $token = auth('user')->login($user, $remember);
        if (!$token) {
            return msg(false, trans('lang.invalid_account'), Response::HTTP_BAD_REQUEST);
        }
        $result['token'] = $token;
        $result['user_data'] = Auth::guard('user')->user();
//        if (config('app.env') == 'local') {
//            $code = 9999;
//        } else {
//            $code = rand(1000, 9999);
//        }

        //Begin Sending SMS
//        $phone =  $data['phone'];
//        $message = trans('Pin Code is') . " : " . $code;
//        $this->sendSms($phone, $message);
        //End Sending SMS

//        $user->login_code = $code;
//        $user->save();

//        $result['otp'] = (int)$code;
//        TODO SMS send function here...

        return msgdata(true, trans('lang.code_sent'), $result, Response::HTTP_OK);
    }

    public function sendSms($to, $message)
    {
        try {
            $client = new Client();
            $response = $client->post(env('MSEGAT_API_URL'), [
                'json' => [
                    'userName' => "Lowcalories",
                    'numbers' => $to,
                    'userSender' => "auth-mseg",
                    'apiKey' => env('MSEGAT_API_KEY'),
                    'msg' => $message,
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
// Handle error
            return ['error' => $e->getMessage()];
        }
    }

    public function signUp(SignUpRequest $request): JsonResponse
    {

        $data = $request->validated();
        DB::beginTransaction();
        if (config('app.env') == 'local') {
            $code = 99999;
        } else {
            $code = rand(10000, 99999);
        }

        //Begin Sending SMS
        $phone = "+966" . $data['phone'];
//        $message = trans('Pin Code is') . " : " . $code;
//        $this->sendSms($phone, $message);
        //End Sending SMS
        $exists_token = PasswordResetToken::where('email', $phone)->first();
        if ($exists_token) {
            $exists_token->token = $code;
            $exists_token->save();
        } else {
            PasswordResetToken::create([
                'email' => $phone,
                'token' => $code,
            ]);
        }


        $result['otp'] = (int)$code;

//        try {
//            $data = [
//                'user_name' => $user->name,
//            ];
//            // Send the email
//            Mail::to($user->email)->send(new SignUpMail($data));
//        } catch (\Exception $e) {
//
//        }
        DB::commit();
        return msgdata(true, trans('lang.success'), $result, ResponseAlias::HTTP_OK);
    }

    public function verifySignUp(verifySignUpRequest $request): JsonResponse
    {
        $data = $request->validated();
//        $data['country_code'] = str_replace('+', '', $data['country_code']);
        $phone = "+966" . $data['phone'];
        if ($data['code'] == "9999") {
            $exist_token = PasswordResetToken::where('email', $phone)->first();
        } else {
            $exist_token = PasswordResetToken::where('email', $phone)->where('token', $data['code'])->first();
        }

        if ($exist_token) {
            $data['email_verified_at'] = Carbon::now();
            $user = User::create($data);
            $token = auth('user')->login($user);
            if (!$token) {
                return msg(false, trans('lang.invalid_account'), ResponseAlias::HTTP_BAD_REQUEST);
            }
            $result['token'] = $token;
            $result['user_data'] = $user;
            $exist_token->delete();
            return msgdata(true, trans('lang.login_s'), $result, ResponseAlias::HTTP_OK);
        } else {
            return msg(false, trans('lang.otp_invalid'), ResponseAlias::HTTP_BAD_REQUEST);

        }
    }

    public function forgetPassword(ForgetPasswordRequest $request): JsonResponse
    {
        $data = $request->validated();
//        $data['country_code'] = str_replace('+', '', $data['country_code']);
        //Begin Sending SMS
        $phone = "+966" . $data['phone'];
//        $message = trans('Pin Code is') . " : " . $code;
//        $this->sendSms($phone, $message);
        //End Sending SMS

        if (config('app.env') == 'local') {
            $code = 99999;
        } else {
            $code = rand(10000, 99999);
        }
        $exists_token = PasswordResetToken::where('email', $phone)->first();
        if ($exists_token) {
            $exists_token->token = $code;
            $exists_token->save();
        } else {
            PasswordResetToken::create([
                'email' => $phone,
                'token' => $code,
            ]);
        }

        $result['otp'] = (int)$code;
        return msgdata(true, trans('lang.success'), $result, ResponseAlias::HTTP_OK);
    }

    public function verifyForgetPassword(VerifyForgetPasswordRequest $request): JsonResponse
    {
        $data = $request->validated();
//        $data['country_code'] = str_replace('+', '', $data['country_code']);
        $phone = "+966" . $data['phone'];
        if ($data['code'] == "9999") {
            $exist_token = PasswordResetToken::where('email', $phone)->first();
        } else {
            $exist_token = PasswordResetToken::where('email', $phone)->where('token', $data['code'])->first();
        }

        if ($exist_token) {
            $result['verified'] = true;
            return msgdata(true, trans('lang.verified_s'), $result, ResponseAlias::HTTP_OK);
        } else {
            $result['verified'] = false;
            return msgdata(false, trans('lang.otp_invalid'), $result, ResponseAlias::HTTP_BAD_REQUEST);

        }
    }

    public function ForgetPasswordUpdatePassword(ForgetPasswordUpdatePasswordRequest $request): JsonResponse
    {
        $data = $request->validated();
//        $data['country_code'] = str_replace('+', '', $data['country_code']);
        $phone = "+966" . $data['phone'];
        if ($data['code'] == "9999") {
            $exist_token = PasswordResetToken::where('email', $phone)->first();
        } else {
            $exist_token = PasswordResetToken::where('email', $phone)->where('token', $data['code'])->first();
        }

        if ($exist_token) {
//            update password here
            User::where('phone', $data['phone'])->update([
                'password' => bcrypt($data['password'])
            ]);
            $exist_token->delete();
            return msg(true, trans('lang.password_changed_s'), ResponseAlias::HTTP_OK);
        } else {

            return msg(false, trans('lang.otp_invalid'), ResponseAlias::HTTP_BAD_REQUEST);

        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(): JsonResponse
    {
        $client = (new UserResource(Auth::guard('user')->user()));
        return msgdata(true, trans('lang.data_display_success'), $client, Response::HTTP_OK);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function profileUpdate(ProfileUpdateRequest $request): JsonResponse
    {
        $data = $request->validated();
        if (isset($data['value_added_certificate_file']) && is_file($data['value_added_certificate_file'])) {
            $data['value_added_certificate_file'] = upload($data['value_added_certificate_file'], 'value_added_certificate_files');
        }
//        $data['country_code'] = str_replace('+', '', $data['country_code']);

        User::where('id', user_id())->update($data);
        $result = User::where('id', user_id())->first();;
        return msgdata(true, trans('lang.data_updated_s'), $result, Response::HTTP_OK);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function submitResetPasswordForm(Request $request): JsonResponse
    {
        $request->validate([
            'country_code' => 'required|string',
            'phone' => 'required|exists:users,phone',
            'token' => 'required|numeric',
        ]);
        $updatePassword = DB::table('user_password_rest')
            ->where([
                'country_code' => $request->country_code,
                'phone' => $request->phone,
                'token' => $request->token
            ])
            ->first();
        if (!$updatePassword) {
            return msgdata(true, trans('lang.token_invalid'), (object)[], Response::HTTP_BAD_REQUEST);
        }
        $client = User::where('country_code', $request->country_code)->where('phone', $request->phone)->first();
        $token = auth('user')->login($client);
        if (!$token) {
            return msg(false, trans('lang.unauthorized'), Response::HTTP_BAD_REQUEST);
        }
        $result['token'] = $token;
        $result['client_data'] = Auth::guard('user')->user();
        DB::table('user_password_rest')->where(['phone' => $request->phone])->delete();
        return msgdata(true, trans('lang.possword_rest'), $result, Response::HTTP_OK);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(Request $request): JsonResponse
    {
        $request->validate([
            'old_password' => 'nullable|string',
            'password' => 'required|string|min:6|confirmed',
        ]);
        $client = auth('user')->user();
        if ($request->old_password) {
            if ($request->old_password) {
                $old_password = Hash::check($request->old_password, $client->password);
                if ($old_password != true) {
                    return msg(false, trans('lang.old_passwordError'), Response::HTTP_BAD_REQUEST);
                }
            }
        }
        User::where('id', $client->id)
            ->update(['password' => bcrypt($request->password)]);
        return msg(true, trans('lang.password_changed_s'), Response::HTTP_OK);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        auth('user')->logout();
        return msg(true, trans('lang.logout_s'), Response::HTTP_OK);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAccount(Request $request): JsonResponse
    {
        DB::beginTransaction();
//        $exists_order = UserPlan::where('user_id', user_id())->whereIn('status', ['pending', 'started'])->first();
//        if ($exists_order) {
//            return msg(false, trans('lang.this_account_has_order_not_completed'), Response::HTTP_BAD_REQUEST);
//        }
//        $exists_order = UserPlan::where('user_id', user_id())->delete();

//        User::whereId(user_id())->forceDelete();
        User::whereId(user_id())->update([
            'manual_deleted' => 1
        ]);
        DB::commit();
        return msg(true, trans('lang.account_deleted_s'), Response::HTTP_OK);
    }

    public function priceRequests(): JsonResponse
    {
        $data = GetPrice::where('user_id', user_id())->orderBy('id', 'desc')->paginate(limit());
//        dd(user_id());
        $result = GetPriceResources::collection($data)->response()->getData(true);
        //    most sell service API
        return msgdata(true, trans('lang.success'), $result, ResponseAlias::HTTP_OK);
    }

    public function priceRequestDetails(GetPrice $get_price): JsonResponse
    {
        $data = new GetPriceDetailsResources($get_price);
        //    most sell service API
        return msgdata(true, trans('lang.success'), $data, ResponseAlias::HTTP_OK);
    }

    public function addWishlist(AddWishlistRequest $request): JsonResponse
    {
        $inputs = $request->validated();
        try {
            $inputs['user_id'] = user_id();
            Wishlist::create($inputs);
            return msg(true, trans('lang.success'), ResponseAlias::HTTP_OK);
        } catch (\Exception $exception) {
            Wishlist::where('user_id', user_id())->where('product_id', $inputs['product_id'])->delete();
            return msg(true, trans('lang.deleted_s'), ResponseAlias::HTTP_OK);

        }
    }

    public function getWishlist(): JsonResponse
    {

        $data = Product::whereHas('wishlists', function ($q) {
            $q->where('user_id', user_id());
        })->paginate(limit());
        $result = ProductResources::collection($data)->response()->getData(true);
        return msgdata(true, trans('lang.success'), $result, ResponseAlias::HTTP_OK);

    }

}

