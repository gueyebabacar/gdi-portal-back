#!/bin/bash

BASH_DIRECTORY=`dirname $0`
PROJECT="${BASH_DIRECTORY}/../"
CACHE="${PROJECT}/cache/"
LOGS="${PROJECT}/logs/"

cd ${PROJECT}

echo "--- Debut reinit ---"

php app/console doctrine:database:drop --force --if-exists -e recette
php app/console doctrine:database:create --if-not-exists -e recette
php app/console doctrine:schema:drop --force -e recette
php app/console doctrine:schema:create -e recette
php app/console cache:clear -e recette
php app/console assets:install web --symlink -e recette

php app/console portal:import regions  -e recette
php app/console portal:import agencies  -e recette
php app/console portal:import users  -e recette

echo "--- Fin reinit ---"