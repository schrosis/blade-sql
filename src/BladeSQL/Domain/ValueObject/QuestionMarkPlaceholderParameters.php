<?php

namespace Schrosis\BladeSQL\BladeSQL\Domain\ValueObject;

class QuestionMarkPlaceholderParameters
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
}
