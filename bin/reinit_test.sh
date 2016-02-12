#!/bin/bash

BASH_DIRECTORY=`dirname $0`
PROJECT="${BASH_DIRECTORY}/../"
CACHE="${PROJECT}/cache/"
LOGS="${PROJECT}/logs/"

cd ${PROJECT}

echo "--- Debut reinit ---"

php app/console doctrine:database:drop --force --if-exists -e test
php app/console doctrine:database:create --if-not-exists -e test
php app/console doctrine:schema:drop --force -e test
php app/console doctrine:schema:create -e test
php app/console cache:clear -e test
php app/console assets:install web --symlink -e test

php app/console doctrine:fixtures:load -n -e test
echo "--- Fin reinit ---"