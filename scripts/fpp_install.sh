#!/bin/bash

# install php-mbstring
rm -rf /home/fpp/.yarn

echo Installing packages..
sudo apt-get update
sudo apt-get -y -o Dpkg::Options::=--force-confdef install sqlite3 php-sqlite3 php-mbstring
curl -o- https://raw.githubusercontent.com/creationix/nvm/v0.33.0/install.sh | bash
curl -o- -L https://yarnpkg.com/install.sh | bash
exec "$BASH"

# install nvm
nvm install --lts
nvm use --lts

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