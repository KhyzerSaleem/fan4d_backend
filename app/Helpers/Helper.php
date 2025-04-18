<?php


use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\PointSetting;
use App\Models\User;
use \App\Models\UserPoint;
use App\Models\Voucher;
use Illuminate\Support\Str;

// Status Codes
function user_id()
{
    return Auth::guard('user')->user()->id;
}


if (!function_exists('limit')) {
    function limit()
    {
        return request()->limit ? request()->limit : 20;
    }
}
function success()
{
    return 200;
}

function register()
{
    return 201;
}

function validation()
{
    return 400;
}

function pending()
{
    return 300;
}

function failed()
{
    return 400;
}

function error()
{
    return 400;
}

function unauthorized()
{
    return 401;
}

function code_sent()
{
    return 402;
}

function token_expired()
{
    return 403;
}

function not_found()
{
    return 404;
}

function complete_register()
{
    return 405;
}

function not_accepted()
{
    return 406;
}


if (!function_exists('addUserPoints')) {

    function addUserPoints($key)
    {
        $user = User::whereId(user_id())->first();
        $point_setting = PointSetting::where('key', $key)->active()->first();

        if (isset($point_setting)) {

            $points = $point_setting->points;
            $user->points += $points;
            $user->save();
            //add user points history ...
            $user_points_data['user_id'] = user_id();
            $user_points_data['points'] = $points;
            $user_points_data['title'] = $key . ' - ' . $point_setting->description;
            $user_points_data['expired_at'] = \Carbon\Carbon::now()->addYear();
            UserPoint::create($user_points_data);
            //end add ...
        } else {
            $points = 0;
        }
        return $points;
    }
}

if (!function_exists('generateReferralCode')) {

    function generateReferralCode()
    {
        // Generate a random string (you can modify this to fit your needs)
        $code = strtoupper(Str::random(8));

        // Ensure the code is unique in the users table
        while (User::where('refer_code', $code)->exists()) {
            $code = strtoupper(Str::random(8));
        }

        return $code;
    }
}
if (!function_exists('generateCouponCode')) {

    function generateCouponCode()
    {
        // Generate a random string (you can modify this to fit your needs)
        $code = strtoupper(Str::random(8));

        // Ensure the code is unique in the users table
        while (Voucher::where('code', $code)->exists()) {
            $code = strtoupper(Str::random(8));
        }

        return $code;
    }
}
if (!function_exists('upload')) {

    function upload($file, $dir = '')
    {
        $fileName = time() . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/' . $dir, $fileName);
        return $fileName;
    }
}

if (!function_exists('settings')) {
    function settings($key)
    {
        $setting = Setting::where('key', $key)->first();

        if (!$setting)
            return null;

        return $setting->value;
    }
}

if (!function_exists('setting_image')) {
    function setting_image($key)
    {
        $setting = Setting::where('key', $key)->first();

        if (!$setting)
            return "";

        return $setting->image;
    }
}

function checkGuard()
{
    if (auth()->guard('admin')->check()) {
        return auth()->guard('admin')->user();
    } else {
        return 0;
    }
}


function google_api_key()
{
    return "AIzaSyAGlTpZIZ49RVV5VX8KhzafRqjzaTRbnn0";
}

function msgdata($status = true, $msg = null, $data = null, $code = 200)
{

    $responseArray = [
        'status' => $code,
        'message' => $msg,
        'data' => $data,
    ];
    return response()->json($responseArray, $code);
}


function msg($status, $msg, $code = 200)
{
    $responseArray = [
        'status' => $code,
        'message' => $msg,
    ];
    return response()->json($responseArray, $code);
}


function sendNotification($token, $title, $msg, $model_type, $model_id , $platform,$api_key)
{

    $fields = array(
        "message" => array(
            "token" => $token,  // Here, you should pass the device token dynamically
            'data' => [
                'title' => $title,
                'body' => $msg,
                'model_type' => (string)$model_type,  // Add model_type to the payload
                'model_id' => (string)$model_id,      // Add model_id to the payload
                'sound' => 'default',
            ],
            'notification' => [
                'title' => $title,
                'body' => $msg,
            ],
        )
    );
    if ($platform == "android") {
        unset($fields['notification']);
    }

    $headers = array('Accept: application/json', 'Content-Type: application/json', 'Authorization: Bearer ' . $api_key);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/low-calories-e6f96/messages:send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
    }
    curl_close($ch);
    return $result;
}

function getServerKey()
{
    return 'AAAAv7yQ-Ys:APA91bHshP3IuBzrQAzZW64TKV8pYM56hw_UJrauqk-8STzJqlBSauQteAKIqyl9FMKZHkFENZq8kw1rkBd5TmauZh6CjgMDtiNAPcxYUqSpVhvrRhYtyHb836sUPctBSBoUCwNX65_Y';
}

function localizedTime($time)
{
    return str_replace(['AM', 'PM'], [__('translation.am'), __('translation.pm')], \Carbon\Carbon::parse($time)->format('H:i A'));
}

function isAdmin(): mixed
{
    return auth()->guard('admin')->user();
}


/***
 * @param string $path
 * @return array
 */
function loadFilesInsideFolder(string $path): array
{
    return File::glob($path . '/*');
}

/**
 * @param string $file
 * @return array
 */
function loadArrayFile(string $file): array
{
    return File::getRequire($file);
}


/**
 * @param string $path
 * @return array
 */
function loadArrayDirectory(string $path): array
{
    $content = [];
    foreach (loadFilesInsideFolder($path) as $file) {
        $content = array_merge($content, loadArrayFile($file));
    }

    return $content;
}





