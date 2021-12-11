<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
        $shortUrlMaxLifeTime = env("SHORT_URL_MAX_LIFE_TIME");

        $currentTime = time();
        $expiredTime = $currentTime+$shortUrlMaxLifeTime;

                    $tmp = DB::table('short_urls')->select("created_at")->where($expiredTime, ">=", "created_at")->get();
                    dd($tmp);

                })->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
