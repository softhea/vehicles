<?php
declare(strict_types=1);

namespace App\Tests\Functional;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;
use App\Tests\Functional\Trait\TypeTrait;
use App\Tests\Functional\Trait\UserTrait;

class MakerControllerTest extends ApiTestCase
{
    use UserTrait;
    use TypeTrait;

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

        $response = $client->request('GET', '/api/makers');

        $this->assertResponseIsSuccessful();

        $response = $response->getContent();
        $this->assertJson($response);
        $response = json_decode($response, true);

        foreach (['BMW', 'Audi', 'VW'] as $key => $expectedMaker) {
            $this->assertArrayHasKey('id', $response[$key]);
            $this->assertSame($expectedMaker, $response[$key]['name']);
        }
    }

    public function testFilteredListEmpty()
    {
        $client = static::createClient([], ['headers' => [
            'Accept' => 'application/json',
        ]]);
        $user = $this->getUser('viewer@example.com');
        $client->loginUser($user);

        $response = $client->request('GET', '/api/makers?type_id=999');

        $this->assertResponseIsSuccessful();

        $response = $response->getContent();
        $this->assertJson($response);
        $response = json_decode($response, true);

        $this->assertSame([], $response);
    }

    public function testFilteredListSuccessfully()
    {
        $firstType = $this->getFirstType();
        $client = static::createClient([], ['headers' => [
            'Accept' => 'application/json',
        ]]);
        $user = $this->getUser('viewer@example.com');
        $client->loginUser($user);

        $response = $client->request('GET', '/api/makers?type_id='.$firstType->getId());

        $this->assertResponseIsSuccessful();

        $response = $response->getContent();
        $this->assertJson($response);
        $response = json_decode($response, true);

        $this->assertCount(1, $response);

        $response = $response[0];

        $this->assertArrayHasKey('id', $response);
        $this->assertSame('BMW', $response['name']);
    }
}
