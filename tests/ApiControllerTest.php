<?php

namespace App\Tests;

use App\Entity\User;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ApiControllerTest extends TestCase
{
    public function testUserCanBeCreated( ): void
    {
        $user = new User();
   
         $user->setPassword("ok");
         $user->setRoles([]);

        $user->setUsername('John Doe');
        $user->setEmail('johndoe@example.com');
        
        $this->assertEquals('John Doe', $user->getUsername());
        $this->assertEquals('johndoe@example.com', $user->getEmail());
         $this->assertTrue(true);
    }
}
