<?php

namespace Schrosis\BladeSQL\Tests\Unit\View;

use Illuminate\Support\Facades\View;
use Schrosis\BladeSQL\Providers\BladeSQLServiceProvider;
use Schrosis\BladeSQL\Tests\TestCase;

class WhereComponentTest extends TestCase
{
    public function testCompile()
    {
        $compiled = View::make('sql::test-where')->render();

        $this->assertStringContainsString("WHERE col_1 = 'value'", $compiled);
        $this->assertStringContainsString("WHERE col_2 = 'value'", $compiled);
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
