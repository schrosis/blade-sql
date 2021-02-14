<?php

namespace Schrosis\BladeSQL\BladeSQL\Domain\Entity;

interface Query
{
    public function getSQL(): string;
    public function getParams(): array;
}
