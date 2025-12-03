.PHONY: up down install-api install-web api-migrate api-seed test

up:
@docker compose up -d --build


down:
@docker compose down


install-api:
@cd apps/api && composer install && composer dump-autoload


install-web:
@cd apps/web && npm install


api-migrate:
@docker compose exec api php artisan migrate --force


api-seed:
@docker compose exec api php artisan db:seed --force


test:
@cd apps/api && vendor/bin/phpunit


logs:
@docker compose logs -f