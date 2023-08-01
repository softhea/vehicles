# Vehicles

Requires: PHP 8.1

## Install

```
git clone https://github.com/softhea/vehicles.git

composer install

php bin/console lexik:jwt:generate-keypair

configure database connection in .env file

php bin/console doctrine:database:create
php bin/console doctrine:database:create --env=test

php bin/console doctrine:migrations:migrate
php bin/console doctrine:migrations:migrate --env=test

php bin/console doctrine:fixtures:load
php bin/console doctrine:fixtures:load --env=test
```

## Functional and Unit Tests

```
php bin/phpunit
```

## Assumptions

