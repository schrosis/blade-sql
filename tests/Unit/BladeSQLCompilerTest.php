<?php

namespace Schrosis\BladeSQL\Tests\Unit;

use Illuminate\Contracts\View\View;
use Mockery\MockInterface;
use Schrosis\BladeSQL\BladeSQL\BladeSQLCompiler;
use Schrosis\BladeSQL\BladeSQL\Domain\Entity\NamedPlaceholderQuery;
use Schrosis\BladeSQL\BladeSQL\UseCase\CompileAction;
use Schrosis\BladeSQL\Tests\TestCase;

class BladeSQLCompilerTest extends TestCase
{
    public function testCompile()
    {
        $blade = 'blade.file.name';
        $params = [
            'array_key' => [1, 2, 3],
            'other_param1' => 'test',
            'other_param2' => null,
        ];
        $view = $this->mock(View::class);

        $this->mock('view')
            ->shouldReceive('make')
            ->withArgs(['sql::'.$blade])
            ->andReturn($view);

        $this->mock(CompileAction::class)
            ->shouldReceive('__invoke')
            ->withArgs([$view, $params]);

        $compiler = $this->app->make(BladeSQLCompiler::class);

        $query = $compiler->compile($blade, $params);
        $this->assertInstanceOf(NamedPlaceholderQuery::class, $query);
    }
}
