<?php

namespace Schrosis\BladeSQL\BladeSQL\Domain\ValueObject;

class NamedPlaceholderParameters
{
    private $value;

    public function __construct(array $value)
    {
        $this->value = $value;
    }

    public function getValue(): array
    {
        return $this->value;
    }

    public function setValue(string $key, $value): self
    {
        $this->value[$key] = $value;
        return $this;
    }
}
