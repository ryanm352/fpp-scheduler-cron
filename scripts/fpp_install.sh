#!/bin/bash

# install php-mbstring
rm -rf /home/fpp/.yarn

echo Installing packages..
#sudo apt-get update
#sudo apt-get -y -o Dpkg::Options::=--force-confdef install sqlite3 php-sqlite3 php-mbstring

# install nvm
curl -o- https://raw.githubusercontent.com/creationix/nvm/v0.33.0/install.sh | bash
export NVM_DIR="/home/fpp/.nvm"
exec bash

# install nvm
nvm install --lts
nvm use --lts

# install yarn
curl -o- -L https://yarnpkg.com/install.sh | bash
exec bash

# migrate table changes
echo Running Migrations...
cd ..
cd scheduler
cp -R -u -p .env.example .env
touch database/scheduler.db
php artisan migrate -n --force

# build front-end
echo Building UI...
cd ..
cd scheduler-ui
yarn update
npm run build

echo Installing Crontab...
# install crontab
crontab -l | grep -v 'php artisan schedule:run'  | crontab -
(crontab -l ; echo "* * * * * cd /home/fpp/media/plugins/fpp-scheduler-cron/scheduler && php artisan schedule:run >> /dev/null 2>&1") | crontab -
echo ...Done!