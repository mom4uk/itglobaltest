PORT ?= 8000

setup: install db-prepare
	

tests:
	php artisan test

lint:
	composer exec --verbose phpcs -- --standard=PSR12 app tests

lint-fix:
	composer exec --verbose phpcbf -- --standard=PSR12 app tests

start-app:
	php artisan serve --host 0.0.0.0 --port ${PORT}

install:
	composer install

db-prepare: db-migrate-seed db-backup

db-migrate-seed:
	php artisan migrate:fresh --seed

db-backup:
	pg_basebackup -h localhost -D dbdata

.PHONY: tests


compose-build:
	docker compose build

compose-start:
	docker compose up --abort-on-container-exit