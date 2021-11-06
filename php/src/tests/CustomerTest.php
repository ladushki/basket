<?php

use Netrebel\Entities\Customer;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{

    public function testGetName()
    {
        $customer = new Customer(1, 'test', 6);
        $this->assertEquals('test', $customer->getName());
    }

    public function testGetId()
    {
        $customer = new Customer(1, 'test', 6);
        $this->assertEquals(1, $customer->getId());
    }
}
