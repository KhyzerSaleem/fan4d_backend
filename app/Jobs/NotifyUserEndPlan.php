<?php

namespace App\Jobs;

use App\Enums\NotificationActionEnum;
use App\Models\Admin;
use App\Models\Notification;
use App\Models\UserPlan;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyUserEndPlan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $plans = UserPlan::where('end_notify_date', '!=', null)
            ->where('end_notify_date', '<=', Carbon::now())
            ->where('end_notified', 0)
            ->whereIn('status', ['pending', 'started'])->get();

        if (count($plans) > 0) {
            foreach ($plans as $plan) {
                try {
                    //send notification
                    $ids = [];
                    array_push($ids, $plan->user->id);

                    Notification::create([
                        'title_ar' => ' تنبية انتهاء الحجز رقم' . $plan->id,
                        'title_en' => 'Reservation Expiration Alert No. ' . $plan->id,
                        'desc_ar' => 'يرجى العلم سيتم انتهاء الحجز الخاصة بك خلال ثلاثة ايام',
                        'desc_en' => 'Please note that your reservation will expire within three days.',
                        'type' => 'reservation',
                        'action' => NotificationActionEnum::notify_end_reservation->value,
                        'target_id' => Admin::first()->id,
                        'target_type' => Admin::class,
                        'user_type' => 'custom',
                        'users' => implode(',', $ids),
                    ]);


                    $selected_plan = UserPlan::whereId($plan->id)->first();
                    $selected_plan->end_notified = 1;
                    $selected_plan->save();
                } catch (\Exception $e) {

                }
            }

        }

    }
}
