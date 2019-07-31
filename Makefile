include .env
-include .env.local
-include .env.${APP_ENV}
-include .env.${APP_ENV}.local

.PHONY: install composer-require composer-remove symfony-console run

MAKEPATH := $(abspath $(lastword $(MAKEFILE_LIST)))
PWD := $(dir $(MAKEPATH))

.DEFAULT_GOAL := run

install:
	@sudo podman container run -it --rm -u `id -u`:`id -g` -v $(PWD):/app composer:latest install

PKG=
composer-require:
	@sudo podman container run -it --rm -u `id -u`:`id -g` -v $(PWD):/app composer:latest require $(PKG)

composer-remove:
	@sudo podman container run -it --rm -u `id -u`:`id -g` -v $(PWD):/app composer:latest remove $(PKG)

CMD=
symfony-console:
	@sudo podman container run -it --rm -u `id -u`:`id -g` -v $(PWD):/app -w /app php:7.4-rc bin/console $(CMD)

run:
	@sudo podman container run -it --rm -u `id -u`:`id -g` -v $(PWD):/app -w /app php:7.4-rc bin/console app:test