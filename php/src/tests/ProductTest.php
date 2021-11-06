<?php

use Netrebel\ValueObjects\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->product = new Product('P001', 'Photography Package', 200);
    }

    public function testGetName()
    {
        $this->assertEquals('Photography Package', $this->product->getName());
    }


    public function testGetUnitPrice()
    {
        $this->assertEquals(200, $this->product->getUnitPrice());
    }

    public function testGetCode()
    {
        $this->assertEquals('P001', $this->product->getCode());
    }
}
