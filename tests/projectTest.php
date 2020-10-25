<?php

namespace App\Tests;


use App\Entity\Project;

use App\Tests\projectTest;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;



class projectTest extends KernelTestCase
{


    /**
     * Récupération d'un user 
     */
   private function getUser(){

        self::bootKernel(); 
        $userRepository = self::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('marlene.lingisi@yahoo.fr');
        return $testUser;

   }

    /**
    * Création d'un projet
    */
    private function createProject()
    {
        return  (new Project())
         ->setNom("Projet 1")
         ->setDateDeDebut(new \DateTime("2020-11-1"))
         ->setDateDeFin(new \DateTime("2020-11-5"))
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
           $messages[] = $error->getPropertyPath() . '=>' . $error->getMessage(); 
        }
        $this->assertCount($number , $errors , \implode( ',' , $messages)); 
   }





   /**
    * Test validation de l'entity
    */
    public function testValidEntity(){
    
        $this->assertHasErrors($this->createProject());
    }


    /**
     * Test controle Nom
     */
    public function testNotBlankNom(){
    
        $this->assertHasErrors($this->createProject()->setNom("") , 1);
    }




    /**
     * Test compare dates date debut > date fin 
     */
    public function testCompareDates(){
    
        $this->assertHasErrors($this->createProject()->setDateDeFin(new \DateTime("2020-9-5")) , 1);
    }


}