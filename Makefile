ifndef DOCKER_PROJECT_NAME
override DOCKER_PROJECT_NAME = market_module
endif

up:
	docker-compose -p $(DOCKER_PROJECT_NAME) -f docker-compose.yaml up -d
up-rebuild:
	docker-compose -p $(DOCKER_PROJECT_NAME) -f docker-compose.yaml up -d --build
down:
	docker-compose -p $(DOCKER_PROJECT_NAME) -f docker-compose.yaml down --remove-orphans
down-clear:
	docker-compose -p $(DOCKER_PROJECT_NAME) -f docker-compose.yaml down --remove-orphans -v
restart:
	docker-compose -p $(DOCKER_PROJECT_NAME) -f docker-compose.yaml down && docker-compose -p $(DOCKER_PROJECT_NAME) -f docker-compose.yaml up -d

database-create:
	docker-compose -p $(DOCKER_PROJECT_NAME) -f docker-compose.yaml run --rm nginx_php-fpm /bin/bash -c "php /var/www/app/bin/console doctrine:database:create --if-not-exists --no-interaction"
database-migrate: database-create
	docker-compose -p $(DOCKER_PROJECT_NAME) -f docker-compose.yaml run --rm nginx_php-fpm /bin/bash -c "php /var/www/app/bin/console doctrine:migrations:migrate --allow-no-migration --all-or-nothing --no-interaction --no-debug "
messenger-setup-transport:
	docker-compose -p $(DOCKER_PROJECT_NAME) -f docker-compose.yaml run --rm nginx_php-fpm /bin/bash -c " php /var/www/app/bin/console messenger:setup-transports --no-interaction --no-debug "
messenger-start-consume:
	docker-compose -p $(DOCKER_PROJECT_NAME) -f docker-compose.yaml exec -T nginx_php-fpm /bin/bash -c "supervisorctl start messenger-consume:*"

dev_initialize-environment: change-context-to-dev down up-rebuild dev_composer-install database-migrate dev_fixtures-load
dev_composer-install:
	docker-compose -p $(DOCKER_PROJECT_NAME) -f docker-compose.yaml run --rm nginx_php-fpm /bin/bash -c "composer install --no-interaction --working-dir=/var/www/app/"
dev_fixtures-load:
	docker-compose -p $(DOCKER_PROJECT_NAME) -f docker-compose.yaml run --rm nginx_php-fpm /bin/bash -c "php /var/www/app/bin/console doctrine:fixtures:load --no-debug --no-interaction"

prod_initialize-environment: change-context-to-prod down up-rebuild prod_composer-install database-migrate
prod_composer-install:
	docker-compose -p $(DOCKER_PROJECT_NAME) -f docker-compose.yaml run --rm nginx_php-fpm /bin/bash -c "composer install --no-dev --optimize-autoloader --no-interaction --working-dir=/var/www/app/ && composer dump-env prod --no-interaction --working-dir=/var/www/app/"

create-env_local:
	cp .env .env.local

change-context-to-prod: create-env_local
	sed -i 's/.docker\/dev\/nginx_php-fpm/.docker\/prod\/nginx_php-fpm/' docker-compose.yaml && sed -i 's/APP_ENV=dev/APP_ENV=prod/' .env.local
change-context-to-dev:
	sed -i 's/.docker\/prod\/nginx_php-fpm/.docker\/dev\/nginx_php-fpm/' docker-compose.yaml && sed -i 's/APP_ENV=prod/APP_ENV=dev/' .env.local
