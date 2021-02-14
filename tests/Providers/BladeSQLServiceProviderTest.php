<?php

namespace Schrosis\BladeSQL\Tests\Providers;

use Illuminate\Support\Facades\View;
use Schrosis\BladeSQL\Providers\BladeSQLServiceProvider;
use Schrosis\BladeSQL\Tests\TestCase;

class BladeSQLServiceProviderTest extends TestCase
{
    public function testServiceProviderPublish()
    {
        $this->assertContains(
            BladeSQLServiceProvider::class,
            BladeSQLServiceProvider::publishableProviders()
        );
    }

    public function testConfigPublish()
    {
        $this->assertFileExists(
            BladeSQLServiceProvider::CONFIG_PATH
        );

        $this->assertArrayHasKey(
            BladeSQLServiceProvider::CONFIG_PATH,
            BladeSQLServiceProvider::pathsToPublish(BladeSQLServiceProvider::class)
        );
    }

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

    protected function getPackageProviders($app)
    {
        return [BladeSQLServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        $this->loadStubSQL($app);
    }
}
