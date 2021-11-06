<?php declare(strict_types = 1);

namespace Netrebel\ValueObjects;

class BasketItem
{
    use Immutable;

    private Product $product;
    private int $quantity;

    /**
     * @param Product $product
     * @param integer $quantity
     */
    public function __construct(Product $product, int $quantity)
    {
        $this->product = $product;
        $this->quantity = $quantity < 0 ? 0 : $quantity;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     * @return $this
     */
    public function add(int $quantity): BasketItem
    {
        return new static($this->product, $this->quantity + $quantity);
    }

    /**
     * @param integer $quantity
     * @return $this
     */
    public function remove(int $quantity): BasketItem
    {
        return new static($this->product, $this->quantity - $quantity);
    }

    /**
     * @return float|int
     */
    public function getTotalAmount(): float|int
    {
        return $this->quantity * $this->product->getUnitPrice();
    }
}