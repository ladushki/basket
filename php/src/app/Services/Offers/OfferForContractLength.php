<?php declare(strict_types = 1);

namespace Netrebel\Services\Offers;

use Netrebel\Entities\Basket;
use Netrebel\ValueObjects\Offer;

class OfferForContractLength implements OfferCalculatorInterface
{
    private static int $length = 12;
    private static float $discount = 10;

    /**
     * @param Basket $basket
     * @return Offer|null
     */
    final public function getOffer(Basket $basket): ?Offer
    {
        $customer = $basket->getCustomer();

        return $customer->getContractLength() === self::$length ? new Offer('Length', self::$discount) : null;
    }
}