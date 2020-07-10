#!/bin/bash

# fpp-plugin-Template install script

cd ..
composer install
crontab -l | grep -v 'fpp-scheduler-cron'  | crontab -
(crontab -l ; echo "* * * * * cd /home/fpp/media/plugins/fpp-scheduler-cron && vendor/bin/crunz schedule:run 1>> /dev/null 2>&1") | crontab -
echo crontab updated