<?php

namespace App\Console;

use GuzzleHttp\Psr7\Response;
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
            echo 'checking if not idle' . PHP_EOL;
            $request = new Request('GET', 'http://localhost/fppjson.php?command=getFPPstatus');
            $promise = $client->sendAsync($request)->then(static function (Response $response) {
                $json = json_decode($response->getBody(), true);
                print_r($json);
                if (!$json['current_playlist']['playlist']) {
                    echo $response->getBody();
                    echo 'player is idle...' . PHP_EOL;
                    echo 'onnit_sign starting!';
                    $client = new Client();
                    $request = new Request('GET', 'http://localhost/fppxml.php?command=startPlaylist&playList=onnit_sign&repeat=checked&playEntry=0');
                    $promise = $client->sendAsync($request)->then(static function ($response) {
                        echo 'hourly started! ' . PHP_EOL . $response->getBody();
                    });
                    $promise->wait();
                }

            });
            $promise->wait();

        })->name('default')->everyMinute();

        $schedule->call(static function () {
            $client = new Client();
            echo 'starting hourly playlist' . PHP_EOL;
            $request = new Request('GET', 'http://localhost/fppxml.php?command=startPlaylist&playList=hourly&repeat=&playEntry=0');
            $promise = $client->sendAsync($request)->then(static function ($response) {
                echo 'hourly started! ' . PHP_EOL . $response->getBody();
            });
            $promise->wait();
            return true;
        })->everyFiveMinutes()
            // restart regular playlist
            ->after(static function () {
                $client = new Client();

                /*$request = new Request('GET', 'http://localhost/api/playlists/stop');
                $promise = $client->sendAsync($request)->then(static function ($response) {
                    echo 'Playlist stopped! ' . PHP_EOL . $response->getBody();
                });
                $promise->wait();*/

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
