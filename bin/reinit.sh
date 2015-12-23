#!/bin/bash

echo "Lancement du reinit..."

if [ "$#" != 1 ]
then
    echo "Usage: reinit.sh env"
    exit
fi

BASH_DIRECTORY=`dirname $0`

sh ${BASH_DIRECTORY}/reinit_$1.sh