#!/bin/bash

# install php-mbstring
sudo apt-get update
sudo apt-get -y -o Dpkg::Options::=--force-confdef install sqlite3 php-sqlite3 nodejs  php-mbstring

# migrate table changes
cd ..
cd scheduler
touch database/scheduler.db
php artisan migrate

# build front-end
cd .. && cd scheduler-ui && npm run build

# install crontab
crontab -l | grep -v 'php artisan schedule:run'  | crontab -
(crontab -l ; echo "* * * * * cd /home/fpp/media/plugins/fpp-scheduler-cron/scheduler && php artisan schedule:run >> /dev/null 2>&1") | crontab -
echo crontab updated