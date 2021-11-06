<?php declare(strict_types = 1);

namespace Netrebel;

use Netrebel\Entities\Basket;
use Netrebel\Entities\Customer;
use Netrebel\Exceptions\BasketException;
use Netrebel\Services\Offers\OfferForContractLength;
use Netrebel\ValueObjects\Product;

class App
{
    public static function run()
    {
        session_start();
        $basketToken = session_id();
        $customer = new Customer(1, 'Larissa', 12);
        $basket = new Basket($basketToken, $customer, new OfferForContractLength);
        try {
            $basket->add(new Product('P001', 'Photography Package', 200), 1);
            $basket->add(new Product('P002', 'Floorplan Package', 100), 1);
            $basket->add(new Product('P003', 'Gas Certificate', 50), 1);
            $basket->add(new Product('P004', 'EICR Certificate', 50), 1);

            echo $customer->getName().' has a contract '.$customer->getContractLength()
                .' months, discount '.$basket->getDiscount().' %. Without discount: '.$basket->getSubtotal().'
            . Total to pay: '.$basket->getTotalAmount();
        } catch (BasketException $e) {
            echo 'Error occurred while adding the products.'.$e->getMessage();
        }
    }
}