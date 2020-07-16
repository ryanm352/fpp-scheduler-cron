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
        /*$schedule->call(static function () {
            $client = new Client();
            echo 'checking if not idle' . PHP_EOL;
            $request = new Request('GET', 'http://localhost/fppjson.php?command=getFPPstatus');
            $promise = $client->sendAsync($request)->then(static function (Response $response) {
                $json = json_decode($response->getBody(), true);
                if (!$json['current_playlist']['playlist']) {
                    echo $response->getBody();
                    echo 'player is idle...' . PHP_EOL;
                    echo 'onnit_sign starting!';
                    $client = new Client();
                    $request = new Request('GET', 'http://localhost/fppxml.php?command=startPlaylist&playList=onnit_sign&repeat=checked&playEntry=0');
                    $promise = $client->sendAsync($request)->then(static function ($response) {
                        echo 'onnit sign started! ' . PHP_EOL . $response->getBody();
                    });
                    $promise->wait();
                }
            });
            $promise->wait();
        })->name('default')->everyMinute()->withoutOverlapping();*/

        $schedule->call(static function () {
            $hourlyPlaylists = [
              'fire_orange',
              'green_chase',
              'green_cyan_chase',
              'red_bounce_green',
              'red_chase',
              'red_nightrider',
              'teal_gray_chase'
            ];
            $playlist = array_rand($hourlyPlaylists);
            dump($playlist);

            $client = new Client();
            echo 'starting hourly playlist' . PHP_EOL;
            $request = new Request('GET', "http://localhost/fppxml.php?command=startPlaylist&playList={$playlist}&repeat=&playEntry=0");
            $promise = $client->sendAsync($request)->then(static function ($response) {
                echo 'hourly started! ' . PHP_EOL . $response->getBody();
            });
            $promise->wait();
        })->name('hourly')->everyFiveMinutes();
    }
}
