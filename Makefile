PORT ?= 8000

setup: install
	php artisan key:generate

tests:
	php artisan test

lint:
	composer exec phpcs -v app

lint-fix:
	composer exec --verbose phpcbf -- --standard=PSR12 app tests

start-app:
	php artisan serve --host 0.0.0.0 --port ${PORT}

test-coverage:
	XDEBUG_MODE=coverage composer exec --verbose phpunit tests -- --coverage-clover build/logs/clover.xml

install:
	composer install

db-prepare-tests:
	php artisan migrate:fresh --seed --database=sqlite

db-prepare:
	php artisan migrate:fresh --seed

.PHONY: tests

compose-start-database:
	docker compose up -d database

compose-setup: compose-build
	docker compose run --rm app make setup

compose-build:
	docker compose build

compose-start:
	docker compose up --abort-on-container-exit