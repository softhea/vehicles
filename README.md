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

I implemented 3 static Vehicle Properties in the Vehicle Entity and all the rest are dinamically built in the pivot Entity VehicleProperty using Property Entity. 
So I considered 7 the max no of Vehicle Properties to assign to a Vehicle.

I only created tests for the 3 asked Endpoints

## Authentication for all requests except for login

```
HEADER "Authorization": "Bearer {TOKEN}"
```

## Implemented API Endpoints


#### ```POST /api/login_check``` to login  {TOKEN} in the response
Request:
```
{
  "username" => "{EMAIL}",
  "password" => "{PASSWORD}"
}
```
Response:
```
{
  "token" => "{TOKEN}"
}
```

#### ```GET /api/makers``` to list Makers 
Reponse:
```
[
  {
    "id" => {MAKER_ID},
    "name" => {MAKER_NAME},
  }
]
```

#### ```GET /api/makers?type_id={TYPE_ID}``` to filter Makers by Vehicle Type ID
Response:
```
{
  "id": {MAKER_ID},
  "name": {MAKER_NAME}
}
```

#### ```GET /api/vehicles/{VEHICLE_ID}``` to show all details of a specific Vehicle
Response:
```
{
    "id": {VEHICLE_ID},
    "model": "MODEL",
    "type": {
        "id": {TYPE_ID},
        "name": "{TYPE_NAME}"
    },
    "maker": {
        "id": {MAKER_ID},
        "name": "{MAKER_NAME}"
    },
    "properties": [
        {
            "id": {VEHICLE_PROPERTY_ID},
            "value": "{PROPERTY_NAME}",
            "name": "{PROPERTY_VALUE}"
        }
    ]
}
```

#### ```POST /api/vehicles/{VEHICLE_ID}/properties``` to create a new VehicleProperty; it creates a new Property if the Property Name doesn't exist
Request:
```
{
  "name" => "{PROPERTY_NAME}",
  "value" => "{PROPERTY_VALUE}"
}
```
Response:
```
{
  "id" => {VEHICLE_PROPERTY_ID}
  "name" => "{PROPERTY_NAME}",
  "value" => "{PROPERTY_VALUE}"
}
```

#### PATCH ```/api/vehicle-properties/{VEHICLE_PROPERTY_ID}``` to update the value of an existing VehicleProperty
Rquest:
```
{
  "value" => {VALUE}
}
```
Response:
```
{
  "id" => {VEHICLE_PROPERTY_ID}
  "name" => "{PROPERTY_NAME}",
  "value" => "{PROPERTY_VALUE}"
}
```

## Not implemented API Endpoints that are needed for this project

```
GET /api/properties to list Properties

POST /api/makers to create a new Maker

POST /api/types to create a new Type
GET /api/types to list Types
```

## Other CRUD API Endpoints that could be implemented

```
POST /api/vehicles to create a new Vehicle
GET /api/vehicles to list Vehicles
PATCH/PUT /api/vehicles/{VEHICLE_ID} to partial or fully update a Vehicle
DELETE /api/vehicles/{VEHICLE_ID} to delete a Vehicle
```

```
PATCH/PUT /api/makers/{MAKER_ID} to partially or fully update a Maker
DELETE /api/makers/{MAKER_ID} to delete a Maker
```

```
PATCH/PUT /api/makers/{MAKER_ID} to update a Maker
DELETE /api/makers/{MAKER_ID} to delete a Maker
```

```
GET /api/types/{TYPE_ID} to show Type details
PATCH/PUT /api/types/{TYPE_ID} to partial or fully update a Type
DELETE /api/types/{TYPE_ID} to delete a Type
```

```
POST /api/properties to create a new Property
GET /api/properties/{PROPERTY_ID} to show Property details
PATCH/PUT /api/properties/{PROPERTY_ID} to partial or fully update a Property
DELETE /api/properties/{PROPERTY_ID} to delete a Property
```

```
DELETE /api/vehicle-properties/{PROPERTY_ID} to delete a VehicleProperty
```
