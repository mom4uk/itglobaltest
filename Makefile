PORT ?= 8000

setup: install
	

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

db-prepare:
	php artisan migrate:fresh --seed

.PHONY: tests


compose-build:
	docker compose build

compose-start:
	docker compose up --abort-on-container-exit