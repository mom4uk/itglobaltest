PORT ?= 8000

setup: install db-prepare # db нужно ли?
	

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


compose-start-database:
	docker compose up -d database

compose-setup: compose-build
	docker compose run --rm application make setup

compose-build:
	docker compose build

compose-start:
	docker compose up --abort-on-container-exit

full-clear: container-stop containers-remove images-clear

containers-remove:
	docker rm $(docker ps -a -q) 

container-stop:
	docker stop $(docker ps -a -q)

images-clear:
	docker rmi $(docker images -q)