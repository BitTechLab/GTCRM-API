ENV_FILE := .env
ENV := $(shell cat $(ENV_FILE))
$(foreach var, $(ENV), $(eval $(var)))

PHP_CONTAINER = $(APP_NAME)-php

# Run local server
default:
	docker compose up

# Run laravel queue listener
queue:
	docker exec -it $(PHP_CONTAINER) php artisan queue:listen

# Run PHPStan analyser
stan:
	vendor/bin/phpstan analyse -c phpstan.neon

force-rebuild:
	docker compose up --build --force-recreate

# Run database migration
db-migrate:
	 docker exec -it $(PHP_CONTAINER) php artisan migrate

# Run database seed
db-seed:
	 docker exec -it $(PHP_CONTAINER) php artisan db:seed

# Run database dummy data seed
db-seed-dummy:
	 docker exec -it $(PHP_CONTAINER) php artisan db:seed-dummy
	 
# Sync vendor directory from PHP container to the host
vendor-sync:
	# rm -rf vendor
	docker cp $(PHP_CONTAINER):/var/www/vendor ./

access-php:
	docker exec -it $(PHP_CONTAINER) sh

test:
	# docker exec -it $(PHP_CONTAINER) php artisan test --env=testing
	docker exec -it $(PHP_CONTAINER) php artisan test

coverage:
	docker exec -it $(PHP_CONTAINER) php artisan test --coverage

