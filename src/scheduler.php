<?php
require_once __DIR__.'/../vendor/autoload.php';

use GO\Scheduler;

// Create a new scheduler
$scheduler = new Scheduler();

// ... configure the scheduled jobs (see below) ...
$scheduler->raw('fpp -L | fpp -P hourly')->everyMinute(2)->output('test.log');
$scheduler->raw('ps aux | grep http')->output('test2.log');

// Let the scheduler execute jobs which are due.
$scheduler->run();