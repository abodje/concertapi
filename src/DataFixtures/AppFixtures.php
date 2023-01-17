<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product = new User();
        $product->setEmail('a');
        $product->setPassword('hhdh');
        $product->setUsername('abodjekou');
        $product->setRoles(['ROLE_ADMIN']);
 
         $manager->persist($product);

        $manager->flush();
    }
}
