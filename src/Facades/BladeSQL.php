<?php

namespace Schrosis\BladeSQL\Facades;

use Illuminate\Support\Facades\Facade;
use Schrosis\BladeSQL\BladeSQL\Contracts\Executor;

/**
 * @method static \Schrosis\BladeSQL\BladeSQL\Domain\Entity\Query compile(string $blade, array $queryParams = [])
 *
 * @see \Schrosis\BladeSQL\BladeSQL\Contracts\Executor
 */
class BladeSQL extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Executor::class;
    }
}
