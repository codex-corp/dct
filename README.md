# DCT Project


Getting started
=============

## Clone the project to local computer

```
git clone origin https://github.com/codex-corp/dct.git
```

## Install the application's dependencies by executing the following command.

> This command uses a small Docker container containing PHP and Composer to install the application's dependencies

```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

## Starting & Stopping Sail

> To start all of the Docker containers:

```
./vendor/bin/sail up
```

> Or start all of the Docker containers in the background ("detached" mode):

```
./vendor/bin/sail up -d
```

> To stop all of the containers, you may simply press Control + C to stop the container's execution

```
./vendor/bin/sail stop
```

## Create Administrator account

```
./vendor/bin/sail artisan db:seed --class="AdminSeeder"
```

## Generate APIs documentation with swagger/postman support

```
./vendor/bin/sail artisan scribe:generate
```

> `postman` collection at `public/docs/collection.json`
> `openapi` collection at `public/docs/openapi.yaml`
