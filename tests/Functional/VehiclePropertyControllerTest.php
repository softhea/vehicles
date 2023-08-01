<?php
declare(strict_types=1);

namespace App\Tests\Functional;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Tests\Functional\Trait\VehiclePropertyTrait;
use App\Tests\Functional\Trait\UserTrait;
use Symfony\Component\HttpFoundation\Response;

class VehiclePropertyControllerTest extends ApiTestCase
{
    use UserTrait;
    use VehiclePropertyTrait;

    public function testEditUnauthorized()
    {
        $client = static::createClient();

        $client->request('PATCH', '/api/vehicle-properties/1');

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    public function testEditForbidden()
    {
        $client = static::createClient();
        $user = $this->getUser('viewer@example.com');
        $client->loginUser($user);

        $client->request('PATCH', '/api/vehicle-properties/1');

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testEditNotFound()
    {
        $client = static::createClient();
        $user = $this->getUser('writer@example.com');
        $client->loginUser($user);

        $client->request('PATCH', '/api/vehicle-properties/999');

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public function testEditMissingValueError()
    {
        $firstVehicleProperty = $this->getFirstVehicleProperty();
        $client = static::createClient();
        $user = $this->getUser('writer@example.com');
        $client->loginUser($user);

        $response = $client->request(
            'PATCH', 
            '/api/vehicle-properties/'.$firstVehicleProperty->getId(),
            ['json' => []]
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);

        $this->assertJson($response->getContent(false));
        $response = json_decode($response->getContent(false), true);

        $this->assertSame(
            [
                "error" => "'value' parameter missing from Request!",
            ], 
            $response
        );

        $notUpdatedVehicleProperty = $this->findVehicleProperty($firstVehicleProperty->getId());

        $this->assertSame('test', $notUpdatedVehicleProperty->getValue());
    }

    public function testEditEmptyValueError()
    {
        $firstVehicleProperty = $this->getFirstVehicleProperty();
        $client = static::createClient();
        $user = $this->getUser('writer@example.com');
        $client->loginUser($user);

        $response = $client->request(
            'PATCH', 
            '/api/vehicle-properties/'.$firstVehicleProperty->getId(),
            ['json' => ['value' => '']]
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);

        $this->assertJson($response->getContent(false));
        $response = json_decode($response->getContent(false), true);

        $this->assertSame(
            [
                "error" => "Value of VehicleProperty cannot be an empty string!",
            ], 
            $response
        );

        $notUpdatedVehicleProperty = $this->findVehicleProperty($firstVehicleProperty->getId());

        $this->assertSame('test', $notUpdatedVehicleProperty->getValue());
    }

    public function editSuccessfullyDataProvider(): array
    {
        return [
            ['updated_value'],
            [null],
        ];
    }

    /**
     * @dataProvider editSuccessfullyDataProvider
     */
    public function testEditSuccessfully(?string $value)
    {
        $firstVehicleProperty = $this->getFirstVehicleProperty();
        $client = static::createClient();
        $user = $this->getUser('writer@example.com');
        $client->loginUser($user);

        $response = $client->request(
            'PATCH', 
            '/api/vehicle-properties/'.$firstVehicleProperty->getId(),
            ['json' => ['value' => $value]]
        );

        $this->assertResponseIsSuccessful();
        
        $updatedVehicleProperty = $this->findVehicleProperty($firstVehicleProperty->getId());

        $this->assertSame($value, $updatedVehicleProperty->getValue());

        $this->assertJson($response->getContent());
        $response = json_decode($response->getContent(), true);

        $this->assertSame(
            [
                'id' => $firstVehicleProperty->getId(),
                'value' => $value,
                'name' => $firstVehicleProperty->getName(),
            ],
            $response
        );
    }
}
