<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

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
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->call(static function () {
            echo 'running command!';
            $client = new Client();
            $request = new Request('GET', 'http://localhost/fppxml.php?command=startPlaylist&playList=hourly&repeat=&playEntry=0&section=');
            $promise = $client->sendAsync($request)->then(static function ($response) {
                echo 'I completed! ' . $response->getBody();
            });
            $promise->wait();
        })->everyFiveMinutes();


      //  http://onnitsigncontroller.local/fppxml.php?command=startPlaylist&playList=hourly&repeat=checked&playEntry=1&section=
    }
}
