<?php

namespace Schrosis\BladeSQL\Tests\Unit\View;

use Illuminate\Support\Facades\View;
use Schrosis\BladeSQL\Providers\BladeSQLServiceProvider;
use Schrosis\BladeSQL\Tests\TestCase;

class TrimComponentTest extends TestCase
{
    public function testCompile()
    {
        $compiled = View::make('sql::test-trim')->render();

        $this->assertStringNotContainsString('invisible-prefix', $compiled);
        $this->assertStringContainsString('visible-prefix', $compiled);
        $this->assertStringNotContainsString('invisible-suffix', $compiled);
        $this->assertStringContainsString('visible-suffix', $compiled);
        $this->assertStringNotContainsString('remove-prefix-string', $compiled);
        $this->assertStringNotContainsString('remove-suffix-string', $compiled);
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
