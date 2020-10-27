<?php

namespace App\Tests;


use App\Entity\Project;

use App\Tests\ProjectTest;
use App\DataFixtures\UserFixture;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


/**
 * Tests unitaires entity Project
 */
class ProjectTest extends KernelTestCase
{

    use FixturesTrait;

    /**
     * Récupération d'un user 
     */
   private function getUser(){

        self::bootKernel(); 
        $this->loadFixtures([UserFixture::class]);//exécute la fixture
        $userRepository = self::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('user-1@user.fr');
        return $testUser;
   }





    /**
    * Création d'un projet
    */
    private function createProject()
    {
    
        return  (new Project())
         ->setNom("Projet test")
         ->setDateDeDebut(new \DateTime("2020-11-05"))
         ->setDateDeFin(new \DateTime("2020-12-05"))
         ->setCreateur($this->getUser());
      
    }
 
 

   /**
    * Récupère les erreurs
    */
   private function assertHasErrors(Project $project , int $number = 0)
   {
        self::bootKernel(); 
        $errors = self::$container->get('validator')->validate($project); 
        $messages = [];
        /** @var ConstrainteViolation $error */
        foreach ($errors as $error) {
           $messages[] = $error->getPropertyPath() . ' => ' . $error->getMessage(); 
        }
        $this->assertCount($number , $errors , \implode( ',' , $messages)); 
   }





   /**
    * Test Création d'un projet
    */
    public function testValidEntity(){
    
        $this->assertHasErrors($this->createProject());
    }


    /**
     * Test Création d'un projet : Champ "Nom" vide
     */
    public function testNotBlankNom(){
    
        $this->assertHasErrors($this->createProject()->setNom("") , 1);
    }




    /**
     * Test Création d'un projet : Champ date fin > date debut 
     */
    public function testCompareDates(){
    
        $this->assertHasErrors($this->createProject()->setDateDeFin(new \DateTime("2020-9-5")) , 1);
    }


}