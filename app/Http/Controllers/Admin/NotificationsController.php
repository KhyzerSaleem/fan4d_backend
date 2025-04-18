<?php

namespace App\Http\Controllers\Admin;

use App\Enums\NotificationActionEnum;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Notification;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationsController extends Controller
{

    public function __construct()
    {
//        $this->middleware('permission:settings_update', ['only' => ['edit','update']]);
    }

    public function renderNotification()
    {
        $users = User::get();
        return view('notifications.send',compact('users'));
    }

    public function sendNotification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_ar' => 'required|min:3',
            'title_en' => 'required|min:3',
            'desc_ar' => 'required|min:3',
            'desc_en' => 'required|min:3',
            'users' => 'nullable|array',
            'users.*' => 'nullable|exists:users,id',
        ]);

        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator->validated());
        }

        $ids = [];
        if (isset($request->users) && !empty($request->users)) {
            $users = User::whereIn('id',$request->users)->select(['id','platform','fcm_token'])->get();
            foreach ($users as $user) {
//                sendNotification([$user->fcm_token],$request->title_ar,$request->desc_ar,'general',null,$user->platform);
                array_push($ids,$user->id);
            }

        }else{ // send to all users
            $users = User::select(['platform','fcm_token'])->get();
            foreach ($users as $user) {
//                sendNotification([$user->fcm_token],$request->title_ar,$request->desc_ar,'general',null,$user->platform);
            }
        }

        Notification::create([
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_en,
            'desc_ar' => $request->desc_ar,
            'desc_en' => $request->desc_en,
            'type' => 'general',
            'action' => NotificationActionEnum::manual_send->value,
            'target_id' => Admin::first()->id,
            'target_type' => Admin::class,
            'user_type' => empty($ids) ? 'all' : 'custom',
            'users' => implode(',',$ids),
        ]);

        session()->flash('success', __('translation.Operation Done Successfully'));
        return redirect()->back();
    }
}
