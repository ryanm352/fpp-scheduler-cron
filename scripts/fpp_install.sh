#!/bin/bash

# fpp-plugin-Template install script
sudo apt-get install sqlite3 php-sqlite3  php-mbstring -y
cd .. && cd scheduler
rm -rf vendor
rm composer.lock
composer install
crontab -l | grep -v 'php artisan schedule:run'  | crontab -
(crontab -l ; echo "* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1") | crontab -
echo crontab updated