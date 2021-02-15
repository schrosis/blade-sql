<?php

namespace Schrosis\BladeSQL\BladeSQL\Contracts;

use Schrosis\BladeSQL\BladeSQL\Domain\Entity\Query;

interface Executor
{
    public function compile(string $blade, array $queryParams = []): Query;
    // public function connection(): Executor;
}