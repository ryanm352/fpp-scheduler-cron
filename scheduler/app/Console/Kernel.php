<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;
use GuzzleHttp\Client;

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
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->call(static function () {
            echo 'running command!';
            $client = new Client();
            $request = new \GuzzleHttp\Psr7\Request('GET', '/fppxml.php?command=startPlaylist&playList=hourly&repeat=&playEntry=1&section=');
            $promise = $client->sendAsync($request)->then(static function ($response) {
                echo 'I completed! ' . $response->getBody();
            });
            $promise->wait();
        })->everyFiveMinutes();


      //  http://onnitsigncontroller.local/fppxml.php?command=startPlaylist&playList=hourly&repeat=checked&playEntry=1&section=
    }
}
