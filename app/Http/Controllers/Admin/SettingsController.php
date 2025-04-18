<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{

    public function __construct()
    {
//        $this->middleware('permission:settings_update', ['only' => ['edit','update']]);
    }

    public function edit()
    {
        $settings = Setting::whereNotIn('key',['reward_points','reward_money'])->get();
        return view('settings.edit',compact('settings'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'site_name_ar' => 'required|min:3',
            'address_ar' => 'required|min:3',
            'site_name_en' => 'required|min:3',
            'address_en' => 'required|min:3',
            'phone' => 'required|min:8',
            'email' => 'required|email',
            'registration_number' => 'required|min:3',
            'website' => 'required|min:3',
            'android_version' => 'required|in:0,1',
            'ios_version' => 'required|in:0,1',
            'facebook' => 'required|url',
            'twitter' => 'required|url',
            'instagram' => 'required|url',
            'accessKey' => 'required|min:10',
            'fav_icon' => 'nullable|mimes:jpeg,png,jpg,gif,svg',
            'logo' => 'nullable|mimes:jpeg,png,jpg,gif,svg',
            'logo_login' => 'nullable|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator->validated());
        }

        foreach ($request->except('_token') as $key => $value) {
            $setting = Setting::where('key', $key)->first();
            if (in_array($key,['fav_icon', 'logo', 'logo_login'])) {
                $setting->image = $value;  // update image
                $setting->save();
            }else {
                $setting->value = $value;  // update value
                $setting->save();
            }

        }

        session()->flash('success', __('Operation Done Successfully'));
        return redirect()->back();
    }
}
