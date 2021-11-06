<?php declare(strict_types = 1);

namespace Netrebel\Services\Offers;

use Netrebel\Entities\Basket;
use Netrebel\ValueObjects\Offer;

class OfferAmount implements OfferCalculatorInterface
{
    private static float $amount = 400;
    private static float $discount = 10;

    final public function getOffer(Basket $basket): ?Offer
    {
        return $basket->getSubtotal() >= self::$amount ? new Offer('400', self::$discount) : null;
    }
}