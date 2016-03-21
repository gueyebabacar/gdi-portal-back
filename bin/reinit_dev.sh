#!/bin/bash

BASH_DIRECTORY=`dirname $0`
PROJECT="${BASH_DIRECTORY}/../"
CACHE="${PROJECT}/cache/"
LOGS="${PROJECT}/logs/"

cd ${PROJECT}

echo "--- Debut reinit ---"
php app/console doctrine:database:drop --force --if-exists -e dev
php app/console doctrine:database:create --if-not-exists -e dev
php app/console doctrine:schema:drop --force -e dev
php app/console doctrine:schema:create -e dev
php app/console cache:clear -e dev
php app/console assets:install web --symlink -e dev

php app/console csv:import:portal:
php app/console csv:import:users:

echo "--- Fin reinit ---"