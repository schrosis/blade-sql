<?php

namespace Schrosis\BladeSQL\Tests\Unit\View;

use Illuminate\Support\Facades\View;
use Schrosis\BladeSQL\Providers\BladeSQLServiceProvider;
use Schrosis\BladeSQL\Tests\TestCase;

class SetComponentTest extends TestCase
{
    public function testCompile()
    {
        $compiled = View::make('sql::test-set')->render();

        $this->assertStringContainsString("col_1 = 'value'", $compiled);
        $this->assertStringNotContainsString("col_1 = 'value',", $compiled);
    }

    protected function getPackageProviders($app)
    {
        return [BladeSQLServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        $this->loadStubSQL($app);
    }
}
