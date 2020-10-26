<?php

namespace App\Tests;

use App\DataFixtures\UserFixture;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthentificationTest extends WebTestCase
{

    use FixturesTrait;

    /**
     * Récupération d'un user 
     */
   private function getUser(){

        self::bootKernel(); 
        $this->loadFixtures([UserFixture::class]); //exécute la fixture
        $userRepository = self::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('user-1@user.fr');
        return $testUser;
   }


   /**
    * Test connexion user-1 avec un mot de passe incorrect
    */
    public function testLoginWithBadCredentials()
    {
       
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Valider')->form([
            '_username' => $this->getUser()->getEmail() , 
            '_password' => 'fakepassword'
        ]);
        $client->submit($form);
        $this->assertResponseRedirects();
        $client->followRedirect(); 
    }



    /**
    * Test connexion user-1 avec un mot de passe correct
    */
    public function testSuccessfullLogin()
    {
       
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Valider')->form([
            '_username' => $this->getUser()->getEmail() , 
            '_password' => "password"
        ]);
        $client->submit($form);
        $this->assertResponseRedirects('http://localhost/');
    }








}