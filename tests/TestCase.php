<?php

namespace Schrosis\BladeSQL\Tests;

use Illuminate\Support\Facades\App;
use Orchestra\Testbench\TestCase as TestbenchTestCase;

class TestCase extends TestbenchTestCase
{
    protected function loadStubSQL(\Illuminate\Foundation\Application $app)
    {
        $app['config']->set('blade-sql.dir', __DIR__.'/stubs/unit/views');
    }
}
