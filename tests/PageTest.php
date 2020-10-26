<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;


class PageTest extends WebTestCase
{

    public function testLogin()
    {
        $client = static::createClient();
        $client->request('GET', '/login');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }


    public function testLogout()
    {
        $client = static::createClient();
        $client->request('GET', '/logout');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }



    public function testHomePageRedirectToLogin()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertResponseRedirects('http://localhost/login');
       
    }

}