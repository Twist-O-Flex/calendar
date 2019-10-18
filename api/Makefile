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

fixtures: run-pgsql
	bin/console hautelook:fixtures:load --no-interaction
