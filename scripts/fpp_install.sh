#!/bin/bash

# install php-mbstring
sudo apt-get update
sudo apt-get -y -o Dpkg::Options::=--force-confdef install sqlite3 php-sqlite3  php-mbstring
# install node
curl -o- https://raw.githubusercontent.com/creationix/nvm/v0.33.11/install.sh | bash
source ~/.bashrc
nvm --version
nvm install --lts
nvm use --lts
node -v
# migrate table changes
cd .. && php scheduler/artisan migrate
# build front-end
cd .. && cd scheduler-ui && npm run build
# install crontab
crontab -l | grep -v 'php artisan schedule:run'  | crontab -
(crontab -l ; echo "* * * * * cd /home/fpp/media/plugins/fpp-scheduler-cron/scheduler && php artisan schedule:run >> /dev/null 2>&1") | crontab -
echo crontab updated