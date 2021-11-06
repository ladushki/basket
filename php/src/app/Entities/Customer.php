<?php declare(strict_types = 1);

namespace Netrebel\Entities;

class Customer
{

    private int $id;
    private string $name;
    private int $contractLength;

    public function __construct(int $id, string $name, int $contractLength = 12)
    {
        $this->id = $id;
        $this->name = $name;
        $this->contractLength = $contractLength;
    }

    /**
     * @return integer
     */
    final public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    final public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return integer
     */
    final public function getContractLength(): int
    {
        return $this->contractLength;
    }
}