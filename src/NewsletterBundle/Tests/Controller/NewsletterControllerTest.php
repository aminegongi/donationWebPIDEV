<?php

namespace NewsletterBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class NewsletterControllerTest extends WebTestCase
{
    public function testNews()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin');
    }

}
