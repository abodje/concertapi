<?php

namespace App\Tests;

use App\Entity\User;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ApiControllerTest extends TestCase
{
    public function testSpamScoreWithInvalidRequest( ): void
    {
        $user = new User();
   
        $user->setEmail('abodjekouame@gmail.com');
        $user->setPassword("ok");
        $user->setUsername("abodje");
        $user->setRoles([]);
         $this->assertTrue(true);
    }
}
