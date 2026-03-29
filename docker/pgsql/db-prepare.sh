#!/usr/bin/env sh
set -e
# Database `sellerstore` is created by the postgres image from POSTGRES_DB.
# This only checks that PostgreSQL accepts connections (CI / local).
sleep 10
docker compose -f docker-compose.ci.yml exec -T pgsql psql -U postgres -d sellerstore -c 'SELECT 1'
docker compose -f docker-compose.ci.yml run --entrypoint="" app ./artisan migrate --force
