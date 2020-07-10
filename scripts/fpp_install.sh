#!/bin/bash

# fpp-plugin-Template install script

cd ..
composer install
(crontab -l ; echo "00 09 * * 1-5 echo hello") | crontab -