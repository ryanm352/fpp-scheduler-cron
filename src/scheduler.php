<?php
require_once __DIR__.'/../vendor/autoload.php';

use Crunz\Schedule;

$schedule = new Schedule();
$task = $schedule->run('fpp -L | fpp -P hourly');
$task->everyMinute();

return $schedule;