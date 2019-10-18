run: run-pgsql

run-pgsql:
	@if ! docker-compose ps pgsql | grep -q Up; then \
		docker-compose up --no-recreate -d pgsql; \
		docker-compose run wait -c pgsql:5432; \
		bin/console doctrine:schema:drop --full-database --force; \
		bin/console doctrine:migration:migrate --no-interaction --allow-no-migration; \
	fi

stop:
	docker-compose stop

test-units: fixtures
	bin/console cache:clear --no-debug --env test
	vendor/bin/phpunit --stop-on-failure --testdox

test-quality:
	docker-compose run --rm -v "${PWD}":/app phpstan analyse -l 4 -c phpstan.neon /app/src /app/tests

test-cs-php:
	docker-compose run --rm -v "${PWD}":/app phpcs --standard=PSR12 src/

fix-cs-php:
	docker-compose run --rm -v "${PWD}":/app phpcbf --standard=PSR12 src/

fixtures: run-pgsql
	bin/console hautelook:fixtures:load --no-interaction
