<?php

namespace App\Console;

use App\Console\Commands\SendNotification;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use DB;
use App\Console\Commands\SendEmails;


class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        SendEmails::class,
        SendNotification::class,
    ];


    protected function schedule(Schedule $schedule)
    {
//         $schedule->command('inspire')->hourly();
        //$schedule->call(function () {
        //    DB::table('recent_users')->delete();
        //})->daily();
        //command:send_emails
        //$schedule->command(SendEmails::class, ['--force'])->hourly();
        $schedule->command('send:notification')->everyMinute()->runInBackground();
        $schedule->command('command:send_emails')->daily()->runInBackground();
        //dd($schedule);
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