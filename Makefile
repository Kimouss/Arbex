DOCKER_COMPOSE  = docker-compose

EXEC_PHP        = $(DOCKER_COMPOSE) exec -T php
EXEC_JS        = $(DOCKER_COMPOSE) exec -T php

SYMFONY         = $(EXEC_PHP) bin/console
COMPOSER        = $(EXEC_PHP) composer
YARN            = $(EXEC_JS) yarn
NPM				= $(EXEC_JS) npm
EXEC_CURL		= curl -X POST -H 'Content-type: application/json' https://hooks.slack.com/services/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 --data

##
## Project
## -------
##

build:
	@$(DOCKER_COMPOSE) pull --ignore-pull-failures
	$(DOCKER_COMPOSE) build --pull

kill:
	$(DOCKER_COMPOSE) kill
	$(DOCKER_COMPOSE) down --volumes --remove-orphans

install: ## Install and start the project
install: .env.local build start ckeditor assets success

reset: ## Stop and start a fresh install of the project
reset: kill install

start: ## Start the project
	$(DOCKER_COMPOSE) up -d --remove-orphans --no-recreate

stop: ## Stop the project
	$(DOCKER_COMPOSE) stop

clean: ## Stop the project and remove generated files
clean: kill
	rm -rf .env.local vendor node_modules

no-docker:
	$(eval DOCKER_COMPOSE := \#)
	$(eval EXEC_PHP := )
	$(eval EXEC_JS := )

notify-pp:
	$(EXEC_CURL) '{"text":"Deploy done in pp"}'

notify-prod:
	$(EXEC_CURL) '{"text":"Deploy done in prod"}'

success:
	@echo '\033[1;32mInstall done\033[0m';

.PHONY: build kill install reset start stop clean no-docker notify-pp notify-prod success

##
## Utils
## -----
##
cache:
cache:
	@$(EXEC_PHP) php -r 'echo "Wait mysql database...\n"; set_time_limit(15); require __DIR__."/vendor/autoload.php"; (new \Symfony\Component\Dotenv\Dotenv())->load(__DIR__."/.env"); $$u = parse_url(getenv("DATABASE_URL")); for(;;) { if(@fsockopen($$u["host"], ($$u["port"] ?? 3306))) { break; }}'
	-$(SYMFONY) cache:clear --no-warmup

mysql: ## Reset the database and load fixtures
mysql: .env.local vendor
	@$(EXEC_PHP) php -r 'echo "Wait mysql database...\n"; set_time_limit(15); require __DIR__."/vendor/autoload.php"; (new \Symfony\Component\Dotenv\Dotenv())->load(__DIR__."/.env"); $$u = parse_url(getenv("DATABASE_URL")); for(;;) { if(@fsockopen($$u["host"], ($$u["port"] ?? 3306))) { break; }}'
	-$(SYMFONY) doctrine:database:drop --if-exists --force
	-$(SYMFONY) doctrine:database:create --if-not-exists
	-$(SYMFONY) doctrine:schema:create
	# $(SYMFONY) doctrine:migrations:migrate --no-interaction --allow-no-migration
	$(SYMFONY) hautelook:fixtures:load --no-interaction

migration: ## Generate a new doctrine migration
migration: vendor
	$(SYMFONY) doctrine:migrations:diff

assets: ## Run Webpack Encore to compile assets
#assets: node_modules
assets: vendor
	$(SYMFONY) assets:install public

ckeditor: vendor
	$(SYMFONY) ckeditor:install --clear=drop

jwt: ## Install JWT Token public key ( no token generation, access token only )
jwt:
	cp config/jwt/CI/*.pem config/jwt/

jwt-override: ## Install JWT Token private en public keys. For token generation
jwt-override:
	rm -rf config/jwt*.pem
	mkdir -p config/jwt
	@echo '\033[1;93mDo not forget to report pass phrase in .env file > JWT_PASSPHRASE\033[0m';
	openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
	openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
	@echo '\033[1;32mKeys created\033[0m';

deploy-dev: ## deploy to dev server
deploy-dev:
	# sh update_oxeva.sh -b develop -f
	sh update_oxeva.sh -b master -f
	#/usr/sbin/container-run oxeva/php-7.4 php bin/console d:m:m --no-interaction --allow-no-migration

deploy-pp: ## deploy to pp
deploy-pp:
	# sh update_oxeva.sh -b dev-master -f
	sh update_oxeva.sh -b preprod -f

deploy-prod: ## deploy to prod
deploy-prod:
	sh update_oxeva.sh -b master -f

update-composer: ## update-composer
update-composer:
	$(COMPOSER) update

.PHONY: mongo mysql migration assets jwt jwt-override update-composer deploy-dev deploy-pp deploy-prod

##
## Tests
## -----
##

test: ## Run unit and functional tests
test: tu

tu: ## Run unit tests
tu: vendor
	$(EXEC_PHP) bin/phpunit --exclude-group functional

.PHONY: test tu

# rules based on files
composer.lock: composer.json
	@ssh-keyscan manon.sogec-marketing.fr >> ~/.ssh/known_hosts
	$(COMPOSER) config http-basic.manon.sogec-marketing.fr gitlab+deploy-token-2 BeuXRffHe4fxsFHVks7x
	$(COMPOSER) update --lock --no-scripts --no-interaction

vendor: composer.lock
	@ssh-keyscan manon.sogec-marketing.fr >> ~/.ssh/known_hosts
	$(COMPOSER) config http-basic.manon.sogec-marketing.fr gitlab+deploy-token-2 BeuXRffHe4fxsFHVks7x
	$(COMPOSER) install

package-lock.json: package.json
	$(NPM) upgrade

node_modules: package-lock.json
	$(NPM) install
	$(NPM) run dev
	@touch -c node_modules

npm_watch:
	$(NPM) run watch

npm_dev:
	$(NPM) run dev

.env.local: .env
	@if [ -f .env.local ]; \
	then\
		echo '\033[1;41m/!\ The .env file has changed. Please check your .env.local file.\033[0m';\
		diff .env .env.local;\
		touch .env.local;\
		exit 1;\
	else\
		echo cp .env .env.local;\
		cp .env .env.local;\
	fi

.DEFAULT_GOAL := help
help:
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
.PHONY: help
