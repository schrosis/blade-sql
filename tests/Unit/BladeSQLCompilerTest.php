<?php

namespace Schrosis\BladeSQL\Tests\Unit;

use Schrosis\BladeSQL\BladeSQL\BladeSQLCompiler;
use Schrosis\BladeSQL\BladeSQL\UseCase\CompileAction;
use Schrosis\BladeSQL\BladeSQL\UseCase\CompileWhereInAction;
use Schrosis\BladeSQL\Providers\BladeSQLServiceProvider;
use Schrosis\BladeSQL\Tests\TestCase;

class BladeSQLCompilerTest extends TestCase
{
    public function testCompile()
    {
        $compiler = new BladeSQLCompiler(
            new CompileAction(
                new CompileWhereInAction()
            )
        );

        $query = $compiler->compile('BladeSQLCompilerTest.test-compile', [
            'user_id_list' => [1, 2],
            'deleted_at' => null,
        ]);

        $sql = $query->getSQL();
        $this->assertStringContainsString('id IN(', $sql);
        $this->assertStringContainsString('deleted_at IS NULL', $sql);
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
