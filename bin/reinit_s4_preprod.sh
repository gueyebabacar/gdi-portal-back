#!/bin/bash

BASH_DIRECTORY=`dirname $0`
PROJECT="${BASH_DIRECTORY}/../"
CACHE="${PROJECT}/cache/"
LOGS="${PROJECT}/logs/"

cd ${PROJECT}

echo "--- Debut reinit ---"
php app/console doctrine:database:drop --force --if-exists -e s4_preprod
php app/console doctrine:database:create --if-not-exists -e s4_preprod
php app/console doctrine:schema:drop --force -e s4_preprod
php app/console doctrine:schema:create -e s4_preprod
php app/console cache:clear -e s4_preprod
php app/console assets:install web --symlink -e s4_preprod

php app/console doctrine:fixtures:load -n

echo "--- Fin reinit ---"
