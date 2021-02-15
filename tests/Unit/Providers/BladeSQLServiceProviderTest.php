<?php

namespace Schrosis\BladeSQL\Tests\Unit\Providers;

use Schrosis\BladeSQL\BladeSQL\BladeSQLCompiler;
use Schrosis\BladeSQL\BladeSQL\BladeSQLExecutor;
use Schrosis\BladeSQL\BladeSQL\Contracts\Compiler;
use Schrosis\BladeSQL\BladeSQL\Contracts\Executor;
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

    public function testResolve()
    {
        $this->assertInstanceOf(
            BladeSQLExecutor::class,
            $this->app->make(Executor::class)
        );

        $this->assertInstanceOf(
            BladeSQLCompiler::class,
            $this->app->make(Compiler::class)
        );
    }

    protected function getPackageProviders($app)
    {
        return [BladeSQLServiceProvider::class];
    }
}
