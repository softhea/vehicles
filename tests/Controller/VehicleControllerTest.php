<?php
declare(strict_types=1);

namespace App\Tests\Controller;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;
use ApiPlatform\Symfony\Bundle\Test\Response as ApiTestResponse;

class VehicleControllerTest extends ApiTestCase
{
    use UserTrait;
    use VehicleTrait;

    public function testShowUnauthorized()
    {
        $client = static::createClient();

        $client->request('GET', '/api/vehicles/1');

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    public function testShowForbidden()
    {
        $client = static::createClient();
        $user = $this->getUser('user@example.com');
        $client->loginUser($user);

        $client->request('GET', '/api/vehicles/1');

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testShowNotFound()
    {
        $client = static::createClient();
        $user = $this->getUser('viewer@example.com');
        $client->loginUser($user);

        $client->request('GET', '/api/vehicles/999');

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public function testShowSuccessfully()
    {
        $firstVehicle = $this->getFirstVehicle();
        $client = static::createClient([], ['headers' => [
            'Accept' => 'application/json',
        ]]);
        $user = $this->getUser('viewer@example.com');
        $client->loginUser($user);

        /** @var ApiTestResponse $response */
        $response = $client->request('GET', '/api/vehicles/'.$firstVehicle->getId());

        $this->assertResponseIsSuccessful();

        $response = $response->getContent();
        $this->assertJson($response);
        $response = json_decode($response, true);

        $this->assertSame(
            [
                "id" => 21,
                "model" => "VW Golf 7",
                "type" => [
                    "id" => 24,
                    "name" => "car",
                ],
                "maker" => [
                    "id" => 24,
                    "name" => "VW",
                ],
                "properties" => [
                    [
                        "value" => "test",
                        "name" => "year",
                    ],
                    [
                        "value" => "test",
                        "name" => "engine_capacity",
                    ],
                    [
                        "value" => "test",
                        "name" => "engine_power",
                    ],
                    [
                        "value" => "test",
                        "name" => "fuel",
                    ],
                    [
                        "value" => "test",
                        "name" => "top_speed",
                    ],
                    [
                        "value" => "test",
                        "name" => "weight",
                    ],
                    [
                        "value" => "test",
                        "name" => "color",
                    ],
                ],
            ],
            $response
        );
    }

    public function testEditUnauthorized()
    {
        $client = static::createClient();

        $client->request('PATCH', '/api/vehicles/1');

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    public function testEditForbidden()
    {
        $client = static::createClient();
        $user = $this->getUser('viewer@example.com');
        $client->loginUser($user);

        $client->request('PATCH', '/api/vehicles/1');

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testEditNotFound()
    {
        $client = static::createClient();
        $user = $this->getUser('writer@example.com');
        $client->loginUser($user);

        $client->request('PATCH', '/api/vehicles/999');

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public function testEditSuccessfully()
    {
        $firstVehicle = $this->getFirstVehicle();
        $client = static::createClient();
        $user = $this->getUser('writer@example.com');
        $client->loginUser($user);

        $client->request('PATCH', '/api/vehicles/'.$firstVehicle->getId());

        $this->assertResponseIsSuccessful();
        // todo
    }
}
