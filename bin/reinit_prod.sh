#!/bin/bash

BASH_DIRECTORY=`dirname $0`
PROJECT="${BASH_DIRECTORY}/../"
CACHE="${PROJECT}/cache/"
LOGS="${PROJECT}/logs/"

cd ${PROJECT}

echo "--- Debut reinit ---"
php app/console doctrine:database:drop --force --if-exists -e prod
php app/console doctrine:database:create --if-not-exists -e prod
php app/console doctrine:schema:drop --force -e prod
php app/console doctrine:schema:create -e prod
php app/console cache:clear -e prod
php app/console assets:install web --symlink -e prod

php app/console portal:import regions  -e prod
php app/console portal:import agencies  -e prod
php app/console portal:import users  -e prod

echo "--- Fin reinit ---"
