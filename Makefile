up:
	docker-compose up -d

down:
	docker-compose down

api-migrate:
	docker-compose exec app php artisan migrate

test:
	docker-compose exec app php artisan test
