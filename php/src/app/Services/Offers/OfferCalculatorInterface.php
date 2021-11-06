<?php declare(strict_types = 1);

namespace Netrebel\Services\Offers;

use Netrebel\Entities\Basket;
use Netrebel\ValueObjects\Offer;

interface OfferCalculatorInterface
{
    /**
     * @param Basket $basket
     * @return Offer|null
     */
    public function getOffer(Basket $basket): ?Offer;
}