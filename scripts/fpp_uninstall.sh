#!/bin/bash

# fpp-plugin-Template uninstall script

cd ..
rm -rf vendor
echo vendor folder removed
crontab -l | grep -v 'echo hello'  | crontab -
echo crontab removed