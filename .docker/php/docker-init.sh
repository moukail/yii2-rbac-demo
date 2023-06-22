#!/usr/bin/env bash

cp .env.dev .env

composer update --no-interaction

echo "-------------------------------------------------------------------"
echo "-                        waiting for DB                           -"
echo "-------------------------------------------------------------------"
while ! nc -z basic-database 3306; do sleep 1; done
echo "-------------------------------------------------------------------"
echo "-                        prepare the DB                           -"
echo "-------------------------------------------------------------------"

# load all migrations
./yii migrate --interactive=0
./yii migrate --interactive=0 --migrationPath=@yii/rbac/migrations

# load all fixtures
./yii fixture "*" --interactive=0

./yii rbac/init

#./yii gii/model --modelClass Post --tableName post
#./yii gii/crud --controllerClass app\\controllers\\PostController --modelClass app\\models\\Post

echo "-------------------------------------------------------------------"
echo "-                        find bugs                                -"
echo "-------------------------------------------------------------------"
#composer phpstan

echo "-------------------------------------------------------------------"
echo "-                        website is ready                         -"
echo "-------------------------------------------------------------------"

php yii serve 0.0.0.0:8000