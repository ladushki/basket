<?php

use Netrebel\Entities\Basket;
use Netrebel\Entities\Customer;
use Netrebel\Services\Offers\OfferAmount;
use Netrebel\Services\Offers\OfferForContractLength;
use Netrebel\Services\Offers\OfferName;
use Netrebel\ValueObjects\BasketItem;
use Netrebel\ValueObjects\Product;
use PHPUnit\Framework\TestCase;

class BasketTest extends TestCase
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

    public function testCanGetId()
    {
        $customer = new Customer(1, 'Name', 12);
        $basket = new Basket('123', $customer);
        $this->assertEquals('123', $basket->getBasketToken());
    }

    public function testCanAdd(): void
    {
        $customer = new Customer(1, 'Name', 12);
        $basket = new Basket('123', $customer, new OfferForContractLength);
        $product = $this->products['P001'];
        $basket->add($product, 1);
        $this->assertInstanceOf(BasketItem::class, $basket->getItems()[0]);
        $this->assertIsArray($basket->getItems());
        $this->assertCount(1, $basket->getItems());
        $this->assertEquals(200, $basket->getSubTotal());
        $this->assertEquals(180, $basket->getTotalAmount());
    }

    public function testOffers(): void
    {
        $customer = new Customer(1, 'Larissa', 12);
        $basket = new Basket('123', $customer, new OfferName);
        $product = $this->products['P001'];
        $basket->add($product, 1);
        $this->assertInstanceOf(BasketItem::class, $basket->getItems()[0]);
        $this->assertIsArray($basket->getItems());
        $this->assertCount(1, $basket->getItems());
        $this->assertEquals(200, $basket->getSubTotal());
        $this->assertEquals(100, $basket->getTotalAmount());
    }
    public function testOfferAmount(): void
    {
        $customer = new Customer(1, 'Larissa', 12);
        $basket = new Basket('123', $customer, new OfferAmount);
        $product = $this->products['P001'];
        $basket->add($product, 1);
        $basket->add($this->products['P002'], 1);
        $basket->add($this->products['P003'], 1);
        $basket->add($this->products['P004'], 1);
        $this->assertInstanceOf(BasketItem::class, $basket->getItems()[0]);
        $this->assertIsArray($basket->getItems());
        $this->assertCount(4, $basket->getItems());
        $this->assertEquals(400, $basket->getSubTotal());
        $this->assertEquals(360, $basket->getTotalAmount());
    }

    public function testCanAddNoDiscount()
    {
        $customer = new Customer(1, 'Name', 6);
        $basket = new Basket('123', $customer);
        $product = $this->products['P001'];
        $basket->add($product, 1);
        $this->assertIsArray($basket->getItems());
        $this->assertCount(1, $basket->getItems());
        $this->assertEquals(200, $basket->getTotalAmount());
    }

    public function testCanNotAddSameProduct()
    {
        $customer = new Customer(1, 'Name', 6);
        $basket = new Basket('123', $customer);
        $product = $this->products['P001'];
        $this->expectException('Netrebel\Exceptions\BasketException');
        $basket->add($product, 2);
    }

    public function testCanAddProduct()
    {
        $customer = new Customer(1, 'Name', 6);
        $basket = new Basket('123', $customer);
        $product = $this->products['P001'];
        $basket->add($product, 1);
        $product2 = $this->products['P002'];
        $basket->add($product2, 1);
        $this->assertCount(2, $basket->getItems());
        $this->assertEquals(300, $basket->getTotalAmount());
        $basket->add($this->products['P003'], 1);
        $this->assertCount(3, $basket->getItems());
        $this->assertEquals(350, $basket->getTotalAmount());
    }

    public function testCanRemove()
    {
        $customer = new Customer(1, 'Name', 6);
        $basket = new Basket('123', $customer);
        $product = $this->products['P001'];
        $basket->add($product, 1);
        $this->assertCount(1, $basket->getItems());
        $basket->remove($product);
        $this->assertCount(0, $basket->getItems());
    }

    public function testCanGetCustomer()
    {
        $customer = new Customer(1, 'Name', 6);
        $basket = new Basket('123', $customer);
        $this->assertEquals('Name', $basket->getCustomer()->getName());
    }

}
