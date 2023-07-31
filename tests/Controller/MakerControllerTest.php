<?php
declare(strict_types=1);

namespace App\Tests\Controller;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;
use ApiPlatform\Symfony\Bundle\Test\Response as ApiTestResponse;

class MakerControllerTest extends ApiTestCase
{
    use UserTrait;

    public function testListUnauthorized()
    {
        $client = static::createClient();

        $client->request('GET', '/api/makers');

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    public function testListForbidden()
    {
        $client = static::createClient();
        $user = $this->getUser('user@example.com');       
        $client->loginUser($user);

        $client->request('GET', '/api/makers');

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testListSuccessfully()
    {
        $client = static::createClient([], ['headers' => [
            'Accept' => 'application/json',
        ]]);
        $user = $this->getUser('viewer@example.com');
        $client->loginUser($user);

        /** @var ApiTestResponse $response */
        $response = $client->request('GET', '/api/makers');

        $this->assertResponseIsSuccessful();
        $response = $response->getContent();
        $this->assertJson($response);
        $response = json_decode($response, true);
        foreach (['BMW', 'Audi', 'VW'] as $key => $expectedMaker) {
            $this->assertArrayHasKey($key, $response);
            $this->assertIsArray($response[$key]);
            $this->assertArrayHasKey('id', $response[$key]);
            $this->assertArrayHasKey('name', $response[$key]);
            $this->assertSame($expectedMaker, $response[$key]['name']);
        }
    }
}
