<?php

namespace App\Jobs;

use App\Models\UserPlan;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StartUserPlan implements ShouldQueue
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
        $un_started_plans = UserPlan::where('status', 'pending')->where('start_date', '<=', Carbon::now())->where('payment_status', 'paid')->where('active_now', 0)->get();
        if (count($un_started_plans) > 0) {
            UserPlan::where('start_date', '<=', Carbon::now())
                ->where('payment_status', 'paid')
                ->where('active_now', 0)
                ->update(['status' => 'started', 'active_now' => 1]);
        }

        $un_finished_plans = UserPlan::where('status', 'started')->where('end_date', '<=', Carbon::now())->where('payment_status', 'paid')->get();
        if (count($un_finished_plans) > 0) {
            UserPlan::where('status', 'started')
                ->where('end_date', '<=', Carbon::now())
                ->where('payment_status', 'paid')
                ->update(['status' => 'finished', 'active_now' => 0]);
        }
    }
}
