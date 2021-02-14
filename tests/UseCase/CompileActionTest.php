<?php

namespace Schrosis\BladeSQL\Tests\UseCase;

use Illuminate\Support\Facades\View;
use RuntimeException;
use Schrosis\BladeSQL\BladeSQL\UseCase\CompileAction;
use Schrosis\BladeSQL\BladeSQL\UseCase\CompileWhereInAction;
use Schrosis\BladeSQL\Providers\BladeSQLServiceProvider;
use Schrosis\BladeSQL\Tests\TestCase;

class CompileActionTest extends TestCase
{
    public function testInvoke()
    {
        $useCase = new CompileAction(
            new CompileWhereInAction()
        );
        $view = View::make('sql::CompileActionTest.test-invoke');
        $params = [
            'user_id_list' => [1, 2, 3],
            'other_param1' => 'test',
            'other_param2' => null,
        ];

        $query = $useCase($view, $params);

        $this->assertEquals(
            $view->with($params)->render(),
            $query->getSQL()
        );

        $this->assertEquals(
            [
                'bladesql_in_user_id_list_0' => 1,
                'bladesql_in_user_id_list_1' => 2,
                'bladesql_in_user_id_list_2' => 3,
                'other_param1' => 'test',
                'other_param2' => null,
            ],
            $query->getParams()
        );
    }

    public function testThrowExceptionWhenNotArrayOrScalarValue()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Only null or scalar or scalar array are allowed');

        $useCase = new CompileAction(
            new CompileWhereInAction()
        );

        $useCase(
            View::make('sql::CompileActionTest.test-invoke'),
            [
                'user_id_list' => [1],
                'other_param' => (object)['not null, not scalar, not scalar array'],
            ]
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
