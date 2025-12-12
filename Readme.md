# How to run

Assuming you have Docker engine installed, run the following commands:

```bash
host# make build
host# make composer-install
host# make phpstan
host# make phpunit
```

## Start the development server

To start the Symfony development server inside Docker:

```bash
host# make server
```

The application will be accessible at http://localhost:8000

Press `Ctrl+C` to stop the server.

## Enter the container

To enter the container bash:

`host# make`
