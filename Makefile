tests:
	php artisan tests

lint:
	composer exec --verbose phpcs -- --standard=PSR12 app tests

lint-fix:
	composer exec --verbose phpcbf -- --standard=PSR12 app tests

start:
	php artisan serve

install:
	composer install

.PHONY: tests