<?php

namespace Schrosis\BladeSQL\Tests\Unit\Facades;

use ReflectionMethod;
use Schrosis\BladeSQL\BladeSQL\Contracts\Executor;
use Schrosis\BladeSQL\Facades\BladeSQL;
use Schrosis\BladeSQL\Tests\TestCase;

class BladeSQLTest extends TestCase
{
    public function testCompile()
    {
        $getFacadeAccessor = new ReflectionMethod(BladeSQL::class, 'getFacadeAccessor');
        $getFacadeAccessor->setAccessible(true);
        $abstract = $getFacadeAccessor->invoke(null);

        $this->assertSame($abstract, Executor::class);
    }
}
