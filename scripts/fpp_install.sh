#!/bin/bash

# fpp-plugin-Template install script

cd ..
composer install
crontab -l | grep -v '/src/scheduler.php'  | crontab -
(crontab -l ; echo "* * * * * php /home/fpp/media/plugins/fpp-scheduler-cron/src/scheduler.php 1>> /dev/null 2>&1") | crontab -u root -
echo crontab updated