<?php declare(strict_types = 1);

namespace Netrebel\ValueObjects;

class Product
{
    use Immutable;

    private string $code;
    private string $name;
    private float $unitPrice;

    /**
     * @param string $code
     * @param string $name
     * @param float  $unitPrice
     */
    public function __construct(string $code, string $name, float $unitPrice)
    {
        $this->code = $code;
        $this->name = $name;
        $this->unitPrice = $unitPrice;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
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
    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }
}