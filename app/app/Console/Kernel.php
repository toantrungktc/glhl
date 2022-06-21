<?php

namespace App\Console;
use App\Setting;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        Commands\SendMail::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {   
        $setting = Setting::find(1);
        // $schedule->command('inspire')->hourly();
        // $schedule->command(SendMail::class)->timezone('Asia/Saigon')->at('14:00');
        $schedule->command('email:key')->everyMinute();
        $schedule->command('email2:key')->monthlyOn($setting->monthly, '08:00')->timezone('Asia/Saigon');
        //$schedule->command('email2:key')->everyMinute();	
        // $schedule->call(function (){
        //     info('called every minute');
        // })->everyMinute();
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
