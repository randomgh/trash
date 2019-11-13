#!/usr/bin/env bash

sudo /usr/sbin/service $1_$2 stop

cd /var/www/$1/$2/

git reset HEAD --hard
git pull

#npm cache clean
#rm -rf node_modules
#rm package-lock.json

#npm i

sudo /usr/sbin/service $1_$2 start

#rm webhook.pid