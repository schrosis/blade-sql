<?php

namespace Schrosis\BladeSQL\BladeSQL\Domain\ValueObject;

class NamedPlaceholderSQL
{
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
