# Run local server
default:
	php artisan serve

# Run local ui
ui:
	npm run dev

# Run laravel queue listener
queue:
	php artisan queue:listen

# Run PHPStan analyser
stan:
	vendor/bin/phpstan analyse -c phpstan.neon

force-rebuild:
	docker compose up --build --force-recreate

# Run database migration
db-migrate:
	 docker exec -it gtcrm-app php artisan migrate

# Run database seed
db-seed:
	 docker exec -it gtcrm-app php artisan db:seed

# Run database dummy data seed
db-seed-dummy:
	 docker exec -it gtcrm-app php artisan db:seed-dummy