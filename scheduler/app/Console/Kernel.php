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
            $client = new Client();
            echo 'starting hourly playlist' . PHP_EOL;
            $request = new Request('GET', 'http://localhost/fppxml.php?command=startPlaylist&playList=hourly&repeat=0&playEntry=0');
            $promise = $client->sendAsync($request)->then(static function ($response) {
                echo 'hourly started! ' . PHP_EOL . $response->getBody();
            });
            $promise->wait();
            return true;
        })->name('hourly')->everyFiveMinutes()
            // restart regular playlist
            ->onSuccess(static function () {
                $client = new Client();

                $request = new Request('GET', 'http://localhost/api/playlists/stop');
                $promise = $client->sendAsync($request)->then(static function ($response) {
                    echo 'Playlist stopped! ' . PHP_EOL . $response->getBody();
                });
                $promise->wait();

                echo 'restarting regular playlist!' . PHP_EOL;
                $request = new Request('GET', 'http://localhost/fppxml.php?command=startPlaylist&playList=onnit_sign&repeat=checked&playEntry=0');
                // Task is complete...
                $promise = $client->sendAsync($request)->then(static function ($response) {
                    echo 'onnit_sign playlist started ' . PHP_EOL . $response->getBody();
                });
                $promise->wait();
                return true;
            });
    }
}
