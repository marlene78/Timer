<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;


class PageTest extends WebTestCase
{

    /**
     * Test accéssibilité page login
     */
    public function testLoginPage()
    {
        $client = static::createClient();
        $client->request('GET', '/login');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }


     /**
     * Test accéssibilité page logout
     */
    public function testLogoutPage()
    {
        $client = static::createClient();
        $client->request('GET', '/logout');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }



     /**
     * Test page home non accéssible aux users non connecté (redirection vers /login)
     */
    public function testHomePageRedirectToLogin()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertResponseRedirects('http://localhost/login');
       
    }

}