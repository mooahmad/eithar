<?php

namespace App\Console;

use App\Events\PushNotificationEvent;
use App\Events\SendEmailsEvent;
use App\Events\SendSMSEvent;
use function foo\func;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Events\UserTransactionsEvent;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
            event(new PushNotificationEvent());

            event(new SendEmailsEvent());

            event(new SendSMSEvent());

            event(new UserTransactionsEvent());

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
