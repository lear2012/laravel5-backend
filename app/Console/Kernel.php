<?php

namespace App\Console;

use App\Models\KeyeRoute;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Redis;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\Inspire::class,
        Commands\SendEmails::class,
        Commands\MultithreadingRequest::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(function () {
            // delete ip thumbup
            $keys = Redis::keys('ip:*');
            foreach($keys as $k) {
                Redis::del($k);
            }
            // update route thumbup in db
            $routes = KeyeRoute::getRouteList();
            foreach($routes as $route) {
                $route->votes = Redis::get('route:'.$route->id.':thumbup');
                $route->save();
            }
        })->daily();
        //
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
