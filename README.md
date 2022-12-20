# Transactional email microservice - code challenge

The original requirements for this assignment can be found in the **__anny.co_** folder.

## Prerequisites:
* [Docker](https://docs.docker.com/get-docker/)

## How to:

### Add the following entry to your /etc/hosts file:

> 127.0.0.1 pgsql

The Postman API endpoint collection can be found in the root catalog: `postman_collection.json`

### Run the command from project's root catalog:

> // first installation with some additional steps: \
> make first-run \
> \
> // later use: \
> make up \
> make down

For more please check the contents of Makefile.

### Database access

Use the following credentials in a database client of your choice:

> DB_HOST: pgsql \
> DB_PORT: 5432 \
> DB_DATABASE: anny_assessment_comments \
> DB_USERNAME: sail \
> DB_PASSWORD: password
