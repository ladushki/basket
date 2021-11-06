<?php declare(strict_types = 1);

namespace Netrebel\Services\Offers;

use Netrebel\Entities\Basket;
use Netrebel\ValueObjects\Offer;

class OfferName implements OfferCalculatorInterface
{
    private static string $name = 'Larissa';
    private static float $discount = 50;

    final public function getOffer(Basket $basket): ?Offer
    {
        $customer = $basket->getCustomer();

        return $customer->getName() === self::$name ? new Offer('Name', self::$discount) : null;
    }
}