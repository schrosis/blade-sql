<?php

namespace Schrosis\BladeSQL\Tests\Unit\UseCase;

use Illuminate\Contracts\View\View;
use Mockery\MockInterface;
use RuntimeException;
use Schrosis\BladeSQL\BladeSQL\UseCase\CompileAction;
use Schrosis\BladeSQL\BladeSQL\UseCase\CompileWhereInAction;
use Schrosis\BladeSQL\Tests\TestCase;

class CompileActionTest extends TestCase
{
    public function testInvoke()
    {
        $this->mock(CompileWhereInAction::class)
            ->shouldReceive('__invoke')
            ->withArgs(['array_key', [1, 2, 3]])
            ->andReturn([]);

        $useCase = $this->app->make(CompileAction::class);

        $params = [
            'array_key' => [1, 2, 3],
            'other_param1' => 'test',
            'other_param2' => null,
        ];

        $this->mock(View::class, function (MockInterface $mock) use ($params) {
            $mock->shouldReceive('with')
                ->withArgs([$params])
                ->andReturn($mock);
            $mock->shouldReceive('render')
                ->andReturn('compiled string');
        });
        $view = $this->app->make(View::class);

        $query = $useCase($view, $params);

        $this->assertSame(
            'compiled string',
            $query->getSQL()
        );

        $this->assertIsArray($query->getParams());
    }

    public function testThrowExceptionWhenNotArrayOrScalarValue()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Only null or scalar or scalar array are allowed');

        $this->mock(CompileWhereInAction::class)
            ->shouldReceive('__invoke');

        $useCase = $this->app->make(CompileAction::class);

        $this->mock(View::class, function (MockInterface $mock) {
            $mock->shouldReceive('with')->andReturn($mock);
            $mock->shouldReceive('render')->andReturn('');
        });
        $view = $this->app->make(View::class);

        $useCase(
            $view,
            ['other_param' => (object)['not null, not scalar, not scalar array']]
        );
    }
}
