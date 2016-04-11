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

php app/console csv:import regions -e test /var/www/web/uploads/csvForTest/regions.csv
php app/console csv:import agencies -e test /var/www/web/uploads/csvForTest/agences.csv
php app/console csv:import users -e test /var/www/web/uploads/csvForTest/utilisateurs.csv

echo "--- Fin reinit ---"