<?php

namespace Schrosis\BladeSQL\Tests;

use Orchestra\Testbench\TestCase as TestbenchTestCase;

class TestCase extends TestbenchTestCase
{
    protected function loadStubSQL(\Illuminate\Foundation\Application $app, bool $is_unit = true)
    {
        $app['config']->set(
            'blade-sql.dir',
            $is_unit ? __DIR__.'/stubs/unit/views' : __DIR__.'/stubs/feature/sql'
        );
    }
}
