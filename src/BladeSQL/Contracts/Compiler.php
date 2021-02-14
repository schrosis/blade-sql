<?php

namespace Schrosis\BladeSQL\BladeSQL\Contracts;

use Schrosis\BladeSQL\BladeSQL\Domain\Entity\Query;

interface Compiler
{
    public function compile(string $blade, array $params = []): Query;
}
