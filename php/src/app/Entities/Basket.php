<?php declare(strict_types = 1);

namespace Netrebel\Entities;

use Netrebel\Exceptions\BasketException;
use Netrebel\Services\Offers\OfferCalculatorInterface;
use Netrebel\ValueObjects\BasketItem;
use Netrebel\ValueObjects\Product;

class Basket
{
    private static int $maxItemPerProduct = 1;
    private string $basketToken;
    private Customer $customer;
    private array $items = [];
    private ?OfferCalculatorInterface $offer;

    /**
     * @param string                        $basketToken
     * @param Customer                      $customer
     * @param OfferCalculatorInterface|null $offer
     */
    public function __construct(string $basketToken, Customer $customer, ?OfferCalculatorInterface $offer = null)
    {
        $this->basketToken = $basketToken;
        $this->customer = $customer;
        $this->offer = $offer;
    }

    /**
     * @return string
     */
    final public function getBasketToken(): string
    {
        return $this->basketToken;
    }

    /**
     * @return array
     */
    final public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return float
     */
    final public function getTotalAmount(): float
    {
        $discount = $this->getDiscount();

        return round($this->getSubTotal() * (1 - $discount / 100), 2);
    }

    /**
     * @param Product $product
     * @param int     $quantity
     * @return void
     * @throws BasketException
     */
    final public function add(Product $product, int $quantity): void
    {
        if (!$this->canAdd($product, $quantity)) {
           return;
        }

        $this->items[] = new BasketItem($product, $quantity);
    }

    /**
     * @param Product $product
     * @return void
     * @throws BasketException
     */
    final public function remove(Product $product): void
    {
        $index = $this->find($product);

        if ($index === null) {
            throw new BasketException('There is no '.$product->getName().' in the basket');
        }

        unset($this->items[$index]);
        ksort($this->items);
    }

    /**
     * @param Product $product
     * @return int|null;
     */
    final public function find(Product $product): ?int
    {
        foreach ($this->items as $i => $item) {
            if ($item->getProduct()->getCode() === $product->getCode()) {
                return $i;
            }
        }

        return null;
    }

    /**
     * @return Customer
     */
    final public function getCustomer(): Customer
    {
        return $this->customer;
    }

    /**
     * @return float
     */
    final public function getSubTotal(): float
    {
        return array_reduce($this->items, static function ($res, $item) {
            return $res + $item->getTotalAmount();
        }, 0);
    }

    /**
     * @return OfferCalculatorInterface|null
     */
    final public function getOffer(): ?OfferCalculatorInterface
    {
        return $this->offer;
    }

    /**
     * @return float
     */
    final public function getDiscount(): float
    {
        $availableOffer = $this->getOffer();

        if (!$availableOffer) {
            return 0;
        }

        return $availableOffer->getOffer($this) ? $availableOffer->getOffer($this)->getDiscount() : 0;
    }

    /**
     * @param OfferCalculatorInterface $offer
     */
    final public function setOffer(OfferCalculatorInterface $offer): void
    {
        $this->offer = $offer;
    }

    /**
     * @param Product $product
     * @param int     $quantity
     * @return bool
     * @throws BasketException
     */
    private function canAdd(Product $product, int $quantity): bool
    {
        $index = $this->find($product);

        if ($quantity > self::$maxItemPerProduct) {
            throw new BasketException('Cannot add more than '.self::$maxItemPerProduct
                .' units of each product.');
        }

        $newQuantity = $index === null
            ? $quantity
            : $this->items[$index]->getQuantity() + $quantity;

        if ($newQuantity > self::$maxItemPerProduct) {
            throw new BasketException('Cannot add more than '.self::$maxItemPerProduct
                .' units of each product.');
        }

        return true;
    }
}