<?php
declare(strict_types=1);

namespace App\Tests\Functional;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Tests\Functional\Trait\PropertyTrait;
use Symfony\Component\HttpFoundation\Response;
use App\Tests\Functional\Trait\UserTrait;
use App\Tests\Functional\Trait\VehicleTrait;

class VehicleControllerTest extends ApiTestCase
{
    use UserTrait;
    use VehicleTrait;
    use PropertyTrait;

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

        $response = $client->request('GET', '/api/vehicles/'.$firstVehicle->getId());

        $this->assertResponseIsSuccessful();

        $response = $response->getContent();
        $this->assertJson($response);
        $response = json_decode($response, true);

        $this->assertSame($firstVehicle->getId(), $response['id']);
        $this->assertSame('VW Golf 7', $response['model']);

        $type = $response['type'];
        $this->assertArrayHasKey('id', $type);
        $this->assertSame('car', $type['name']);

        $maker = $response['maker'];
        $this->assertArrayHasKey('id', $maker);
        $this->assertSame('VW', $maker['name']);

        $vehicleProperties = $response['properties'];
        foreach ($this->getFirstProperties() as $key => $property) {
            $this->assertArrayHasKey('id', $vehicleProperties[$key]);
            $this->assertSame($property->getName(), $vehicleProperties[$key]['name']);
            $this->assertSame('test', $vehicleProperties[$key]['value']);
        }        
    }    
}
