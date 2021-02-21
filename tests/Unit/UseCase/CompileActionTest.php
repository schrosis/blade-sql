<?php

namespace Schrosis\BladeSQL\Tests\Unit\UseCase;

use Illuminate\Contracts\View\View;
use Mockery\MockInterface;
use RuntimeException;
use Schrosis\BladeSQL\BladeSQL\Domain\ValueObject\NamedPlaceholderParameters;
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
            $arg = $params;
            $arg['__bladesqlparams'] = new NamedPlaceholderParameters($params);
            $mock->shouldReceive('with')
                ->withArgs([$arg])
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
}
