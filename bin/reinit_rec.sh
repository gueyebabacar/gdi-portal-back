#!/bin/bash

BASH_DIRECTORY=`dirname $0`
PROJECT="${BASH_DIRECTORY}/../"
CACHE="${PROJECT}/cache/"
LOGS="${PROJECT}/logs/"

cd ${PROJECT}

echo "--- Debut reinit ---"

php app/console doctrine:database:drop --force --if-exists -e rec
php app/console doctrine:database:create --if-not-exists -e rec
php app/console doctrine:schema:drop --force -e rec
php app/console doctrine:schema:create -e rec
php app/console cache:clear -e rec
php app/console assets:install web --symlink -e rec

php app/console doctrine:fixtures:load -n --fixtures= src/TranscoBundle/DataFixtures/ORM -e rec --append
php app/console doctrine:fixtures:load -n --fixtures= src/PortalBundle/DataFixtures/ORM -e rec --append

echo "--- Fin reinit ---"