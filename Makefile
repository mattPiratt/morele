.PHONY: phpunit phpstan build bash server


# Open a bash shell in the container
bash:
	@docker run --rm -it -v $(PWD):/var/www recruitment_morele bash

# Build the Docker image
build:
	@docker build -t recruitment_morele .

# Run PHPUnit tests
phpunit:
	@docker run --rm -v $(PWD):/var/www recruitment_morele ./bin/phpunit

# Run PHPStan for static analysis
phpstan:
	@docker run --rm -v $(PWD):/var/www recruitment_morele ./vendor/phpstan/phpstan/phpstan analyse

# Install dependencies with Composer
composer-install: build
	@docker run --rm -v $(PWD):/var/www recruitment_morele composer install

# Start the Symfony development server (accessible at http://localhost:8000)
server:
	@docker run --rm -it -v $(PWD):/var/www -p 8000:8000 recruitment_morele php -S 0.0.0.0:8000 -t public
