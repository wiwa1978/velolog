#!make

rebuild:
	@docker-compose down --remove-orphans
	@docker-compose up -d --build
	@docker exec velolog-app composer install -on
	@docker exec velolog-app php artisan migrate:fresh --seed
	@docker exec velolog-app php artisan passport:install

down:
	@docker-compose down --remove-orphans

stop:
	@docker-compose stop

status:
	@docker-compose ps

stats:
	@docker stats velolog-app velolog-webserver velolog-mysql

refresh-db:
	@docker exec velolog-app php artisan migrate:fresh --seed

restart:
	@docker-compose restart

shell:
	@docker exec -it velolog-app /bin/bash -c "export COLUMNS=`tput cols`; export LINES=`tput lines`; exec bash"

logs:
	@docker-compose logs -f --tail=100
