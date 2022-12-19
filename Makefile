.PHONY: first-run prepare-env up down composer-install migrate migrate-rollback db-seed test artisan

first-run: prepare-env up composer-install migrate db-seed

prepare-env:
	cp .env.example .env

up:
	./vendor/bin/sail up -d

down:
	./vendor/bin/sail down

composer-install:
	./vendor/bin/sail composer install

generate-key:
	./vendor/bin/sail artisan key:generate

migrate:
	./vendor/bin/sail artisan migrate

migrate-rollback:
	./vendor/bin/sail artisan migrate:rollback

db-seed:
	./vendor/bin/sail artisan db:seed

test:
	./vendor/bin/sail test

artisan:
	./vendor/bin/sail exec -it laravel.test bash
