<?php

use Netrebel\ValueObjects\Offer;
use PHPUnit\Framework\TestCase;

class OfferTest extends TestCase
{

    public function testGetName()
    {
        $offer = new Offer('test', 0);
        $this->assertEquals('test', $offer->getName());
    }

    public function testGetDiscount()
    {
        $offer = new Offer('test', 10);
        $this->assertObjectHasAttribute('discount', $offer);
        $this->assertEquals(10, $offer->getDiscount());
    }
}
