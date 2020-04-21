#!make

rebuild:
	@docker-compose down --remove-orphans
	@docker-compose up -d --build
	@docker exec laravel-docker-boilerplate-app composer install -on
	@docker exec laravel-docker-boilerplate-app php artisan migrate:fresh --seed

down:
	@docker-compose down --remove-orphans

stop:
	@docker-compose stop

status:
	@docker-compose ps

stats:
	@docker stats laravel-docker-boilerplate-app laravel-docker-boilerplate-webserver laravel-docker-boilerplate-mysql

refresh-db:
	@docker exec laravel-docker-boilerplate-app php artisan migrate:fresh --seed

restart:
	@docker-compose restart

shell:
	@docker exec -it laravel-docker-boilerplate-app /bin/bash -c "export COLUMNS=`tput cols`; export LINES=`tput lines`; exec bash"

logs:
	@docker-compose logs -f --tail=100
