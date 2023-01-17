<?php

namespace App\Tests;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class ApiControllerTest extends TestCase
{
    public function testSettingCustomerFirstName(): void
    {
        $customer = new User();
        $firstName = "John";

        $customer->setUsername($firstName);

        $this->assertEquals($firstName, $customer->getUsername());
     }
}
