<?php

namespace App\Domain\ValueObject;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;


class GastoId
{
    private string $id;

   
    private function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromString(string $id): self
    {
        return new self($id);
    }

   
        public static function generate(): self
        {
            return new self(uniqid('gasto_', true));
        }

   

    public function equals(GastoId $other): bool
    {
        return $this->id === $other->id;
    }

   
    public function toString(): string
    {
        return $this->id;
    }

   
    public function __toString(): string
    {
        return $this->toString();
    }
}
?>