<?php declare(strict_types = 1);

namespace Netrebel\ValueObjects;

class Offer
{

    use Immutable;

    private string $name;
    private float $discount;

    public function __construct(string $name, float $discount)
    {
        $this->name = $name;
        $this->discount = $discount;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getDiscount(): float
    {
        return $this->discount;
    }

}