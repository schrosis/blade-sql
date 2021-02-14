<?php

namespace Schrosis\BladeSQL\Tests\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Schrosis\BladeSQL\Providers\BladeSQLServiceProvider;
use Schrosis\BladeSQL\Tests\TestCase;

class ResoleveBladeTest extends TestCase
{

    public function testResolveSQLBlade()
    {
        $viewString = View::make('sql::BladeSQLServiceProviderTest.test-resolve')->render();

        $this->assertStringContainsString(
            'sql blade is resolved',
            $viewString
        );

        $this->assertStringContainsString(
            'laravel'.$this->getMainVersion(),
            $viewString
        );
    }

    public function testResolveInDirective()
    {
        $this->assertArrayHasKey('IN', Blade::getCustomDirectives());
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
