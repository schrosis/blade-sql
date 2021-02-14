<?php

namespace Schrosis\BladeSQL\Tests;

use Schrosis\BladeSQL\BladeSQL\BladeSQLExecutor;
use Schrosis\BladeSQL\BladeSQL\Contracts\Compiler;

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
}
