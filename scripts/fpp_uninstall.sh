#!/bin/bash

# fpp-plugin-Template uninstall script

cd ..
rm -rf vendor
echo vendor folder removed
crontab -l | grep -v 'src/scheduler.php'  | crontab -
echo crontab removed