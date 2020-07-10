#!/bin/bash

# fpp-plugin-Template uninstall script

cd ..
rm -rf vendor
crontab -l | grep -v 'echo hello'  | crontab -