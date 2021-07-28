.PHONY: tests
service=app

up:
	docker-compose up -d

up-with-db:
	docker-compose --profile=db up -d

build:
	docker-compose rm -vsf
	docker-compose down -v --remove-orphans
	docker-compose build

stop:
	docker-compose stop

down:
	docker-compose down

install:
	docker-compose run --rm --entrypoint "" ${service} composer install

update:
	docker-compose run --rm --entrypoint "" ${service} composer update

require:
	docker-compose run --rm --entrypoint "" ${service} composer require

require-dev:
	docker-compose run --rm --entrypoint "" ${service} composer require --dev

enter:
	docker-compose exec ${service} bash

run:
	docker-compose run --rm --entrypoint "" ${service} bash

tests:
	docker-compose run --rm --entrypoint "" ${service} ./artisan test

stan:
	docker-compose run --rm --entrypoint "" ${service} ./vendor/bin/phpstan analyse .

tail-logs:
	docker-compose logs -f ${service}

hook-pre-commit:
	docker-compose run --rm --entrypoint "" ${service} ./git-hooks/pre-commit.sh

hook-pre-push:
	docker-compose run --rm --entrypoint "" ${service} ./git-hooks/pre-push.sh