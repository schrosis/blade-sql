<?php

namespace Schrosis\BladeSQL\Tests;

use Schrosis\BladeSQL\BladeSQL\BladeSQLCompiler;
use Schrosis\BladeSQL\BladeSQL\UseCase\CompileAction;
use Schrosis\BladeSQL\BladeSQL\UseCase\CompileWhereInAction;
use Schrosis\BladeSQL\Providers\BladeSQLServiceProvider;

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
        $this->assertStringContainsString(':bladesql_in_user_id_list_0', $sql);
        $this->assertStringContainsString(':bladesql_in_user_id_list_1', $sql);
        $this->assertStringContainsString('deleted_at IS NULL', $sql);

        $params = $query->getParams();
        $this->assertEquals(
            [
                'bladesql_in_user_id_list_0' => 1,
                'bladesql_in_user_id_list_1' => 2,
                'deleted_at' => null,
            ],
            $params
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
