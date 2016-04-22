#!/bin/bash

BASH_DIRECTORY=`dirname $0`
PROJECT="${BASH_DIRECTORY}/../"
CACHE="${PROJECT}/cache/"
LOGS="${PROJECT}/logs/"

cd ${PROJECT}

echo "--- Debut reinit ---"

php app/console doctrine:database:drop --force --if-exists -e s4_rt
php app/console doctrine:database:create --if-not-exists -e s4_rt
php app/console doctrine:schema:drop --force -e s4_rt
php app/console doctrine:schema:create -e s4_rt
php app/console cache:clear -e s4_rt
php app/console assets:install web --symlink -e s4_rt

php app/console portal:import regions  -e s4_rt
php app/console portal:import agencies  -e s4_rt
php app/console portal:import users  -e s4_rt

echo "--- Fin reinit ---"