#!/bin/bash

# install php-mbstring
echo Installing packages..
sudo apt-get update
sudo apt-get -y -o Dpkg::Options::=--force-confdef install sqlite3 php-sqlite3 nodejs yarn  php-mbstring

# migrate table changes
echo Running Migrations...
cd ..
cd scheduler
touch database/scheduler.db
php artisan migrate --force

# build front-end
echo Building UI...
cd .. && cd scheduler-ui && npm run build

echo Installing Crontab...
# install crontab
crontab -l | grep -v 'php artisan schedule:run'  | crontab -
(crontab -l ; echo "* * * * * cd /home/fpp/media/plugins/fpp-scheduler-cron/scheduler && php artisan schedule:run >> /dev/null 2>&1") | crontab -
echo ...Done!