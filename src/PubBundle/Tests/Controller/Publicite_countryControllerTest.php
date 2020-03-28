<?php

namespace PubBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class Publicite_countryControllerTest extends WebTestCase
{
    public function testUpdatemap()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/updateMap');
    }

}
