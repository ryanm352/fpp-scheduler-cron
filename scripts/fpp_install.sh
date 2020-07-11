#!/bin/bash

# fpp-plugin-Template install script
sudo apt-get update
sudo apt-get -y -o Dpkg::Options::=--force-confdef install sqlite3 php-sqlite3  php-mbstring
crontab -l | grep -v 'php artisan schedule:run'  | crontab -
(crontab -l ; echo "* * * * * cd /home/fpp/media/plugins/fpp-scheduler-cron/scheduler && php artisan schedule:run >> /dev/null 2>&1") | crontab -
echo crontab updated