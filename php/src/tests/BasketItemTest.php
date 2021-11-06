<?php

use Netrebel\ValueObjects\BasketItem;
use Netrebel\ValueObjects\Product;
use PHPUnit\Framework\TestCase;

class BasketItemTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->products = [
            'P001' => new Product('P001', 'Photography Package', 200),
            'P002' => new Product('P002', 'Floorplan Package', 100),
            'P003' => new Product('P003', 'Gas Certificate', 50),
            'P004' => new Product('P004', 'EICR Certificate', 50),
        ];
    }

    public function testAdd()
    {
        $item = new BasketItem($this->products['P001'], 1);
        $changed = $item->add(2);
        $this->assertEquals(3, $changed->getQuantity());
    }

    public function testGetTotalAmount()
    {
        $item = new BasketItem($this->products['P003'], 3);
        $this->assertEquals(150, $item->getTotalAmount());
    }

    public function testRemove()
    {
        $item = new BasketItem($this->products['P001'], 3);
        $this->assertEquals(600, $item->getTotalAmount());
        $changed = $item->remove(1);
        $this->assertEquals(2, $changed->getQuantity());
        $this->assertEquals(400, $changed->getTotalAmount());
    }
}
