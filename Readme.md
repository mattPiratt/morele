# How to run

Assuming you have Docker engine installed, run the following commands:

```bash
host# make build
host# make composer-install
host$ make
docker$ ./bin/console doctrine:migrations:migrate
docker$ ./bin/console doctrine:migrations:migrate --env=test
docker$ ./bin/console doctrine:fixtures:load
docker$ exit
host# make phpstan
host# make phpunit
```

## Start the development server

To start the Symfony development server inside Docker, first load provided exampe data:

```bash

```

then run the server:

```bash
host$ make server
```

The application will be accessible at http://localhost:8000

Press `Ctrl+C` to stop the server.

## Enter the container

To enter the container bash:

`host# make`
