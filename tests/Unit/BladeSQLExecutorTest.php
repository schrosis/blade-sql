<?php

namespace Schrosis\BladeSQL\Tests\Unit;

use Schrosis\BladeSQL\BladeSQL\BladeSQLExecutor;
use Schrosis\BladeSQL\BladeSQL\Contracts\Compiler;
use Schrosis\BladeSQL\BladeSQL\UseCase\LikeEscapeAction;
use Schrosis\BladeSQL\Tests\TestCase;

class BladeSQLExecutorTest extends TestCase
{
    public function testCompile()
    {
        $args = [
            'sql.blade.file',
            [
                'array' => [1, 2],
                'nullable' => null,
            ]
        ];
        $this->mock(Compiler::class)
            ->shouldReceive('compile')
            ->withArgs($args);

        $executor = $this->app->make(BladeSQLExecutor::class);
        $executor->compile(...$args);
    }

    public function testLikeEscape()
    {
        $this->mock(Compiler::class);
        $this->mock(LikeEscapeAction::class)
            ->shouldReceive('__invoke')
            ->withArgs(['keyword'])
            ->andReturn('keyword');

        $executor = $this->app->make(BladeSQLExecutor::class);
        $executor->likeEscape('keyword');
    }
}
