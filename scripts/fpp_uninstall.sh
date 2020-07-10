#!/bin/bash

# fpp-plugin-Template uninstall script
cd .. && cd scheduler
rm -rf vendor
echo vendor folder removed
crontab -l | grep -v 'php artisan schedule:run'  | crontab -
echo crontab removed