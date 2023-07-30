<?php
declare(strict_types=1);

namespace App\Tests\Controller;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;
use ApiPlatform\Symfony\Bundle\Test\Response as ApiTestResponse;

class VehicleControllerTest extends ApiTestCase
{
    use UserTrait;

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
        $client = static::createClient();
        $user = $this->getUser('viewer@example.com');
        $client->loginUser($user);
        $client->request('GET', '/api/vehicles/1');

        $this->assertResponseIsSuccessful();
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
        $client = static::createClient();
        $user = $this->getUser('writer@example.com');
        $client->loginUser($user);
        $client->request('PATCH', '/api/vehicles/1');

        $this->assertResponseIsSuccessful();
    }
}
