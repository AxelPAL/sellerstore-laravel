#!/usr/bin/env bash

docker-compose -f docker-compose.ci.yml exec mysql mysql -e 'create database if not exists sellerstore;'
docker-compose -f docker-compose.ci.yml run --entrypoint="" app ./artisan migrate