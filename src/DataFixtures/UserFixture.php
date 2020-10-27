<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class UserFixture extends Fixture
{
   

    public function load(ObjectManager $manager)
    {
        // create 5 users
        for ($i = 0; $i < 5; $i++) {
             $user = new User();
             $user->setNom("User-$i");
             $user->setPrenom("User-$i");
             $user->setEmail("user-$i@user.fr");
             $user->setPassword('$2y$10$pLh..2uwfrHeIvc9.706AODoa9HRcynhk7U/mKXVMHyQvF9WEUYZK');
             $user->setConfirmPassword('$2y$10$pLh..2uwfrHeIvc9.706AODoa9HRcynhk7U/mKXVMHyQvF9WEUYZK');
             $manager->persist($user); 
             
         }
 
        $manager->flush();
     
    }

}