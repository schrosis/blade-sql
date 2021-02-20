<?php

namespace Schrosis\BladeSQL\BladeSQL\Domain\ValueObject;

class QuestionMarkPlaceholderSQL
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
