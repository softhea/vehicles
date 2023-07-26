<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MakerControllerTest extends WebTestCase
{
    public function testShow(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/vehicles/1');

        $this->assertResponseIsSuccessful();
    }

    public function testEdit(): void
    {
        $client = static::createClient();
        $crawler = $client->request('PATCH', '/vehicles/1');

        $this->assertResponseIsSuccessful();
    }
}
