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
        $client->request('GET', '/makers');

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    public function testListForbidden()
    {
        $client = static::createClient();
        $user = $this->getUser('user@example.com');       
        $client->loginUser($user);
        $client->request('GET', '/makers');

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testListSuccessfully()
    {
        $client = static::createClient();
        $user = $this->getUser('viewer@example.com');
        $client->loginUser($user);

        /** @var ApiTestResponse $response */
        $response = $client->request('GET', '/makers');

        $this->assertResponseIsSuccessful();

        // dd($response->getContent());

        $this->assertJsonEquals([
            [
                'id' => 1,
                'name' => 'BMW',
            ],
            [
                'id' => 2,
                'name' => 'Audi',
            ],
            [
                'id' => 3,
                'name' => 'VW',
            ],
        ]);
    }
}
