<?php

namespace Schrosis\BladeSQL\Tests\Unit;

use Illuminate\Database\ConnectionInterface;
use ReflectionMethod;
use ReflectionProperty;
use Schrosis\BladeSQL\BladeSQL\BladeSQLExecutor;
use Schrosis\BladeSQL\BladeSQL\Contracts\Compiler;
use Schrosis\BladeSQL\BladeSQL\SelectResultCollection;
use Schrosis\BladeSQL\BladeSQL\UseCase\LikeEscapeAction;
use Schrosis\BladeSQL\BladeSQL\UseCase\SelectAction;
use Schrosis\BladeSQL\BladeSQL\UseCase\UpdateAction;
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

    public function testConnection()
    {
        $this->mock(Compiler::class);
        $this->mock(LikeEscapeAction::class);
        $executor = $this->app->make(BladeSQLExecutor::class);

        $connectionProp = new ReflectionProperty(BladeSQLExecutor::class, 'connection');
        $connectionProp->setAccessible(true);

        $executor->setConnection(null);
        $this->assertSame(null, $connectionProp->getValue($executor));

        $executor->setConnection('mysql');
        $this->assertSame('mysql', $connectionProp->getValue($executor));

        $this->mock(ConnectionInterface::class);
        $connection = $this->app->make(ConnectionInterface::class);
        $executor->setConnection($connection);
        $this->assertSame($connection, $connectionProp->getValue($executor));

        $getConnection = new ReflectionMethod(BladeSQLExecutor::class, 'getConnection');
        $getConnection->setAccessible(true);
        $this->assertSame(
            $connection,
            $getConnection->invoke($executor)
        );
    }

    public function testSelect()
    {
        $this->mock(Compiler::class)->expects('compile');
        $this->mock(ConnectionInterface::class);
        $this->mock(SelectAction::class)->expects('__invoke');
        $executor = $this->app->make(BladeSQLExecutor::class);

        $this->assertInstanceOf(
            SelectResultCollection::class,
            $executor->select('blade-name', [])
        );
    }

    public function testUpdate()
    {
        $this->mock(Compiler::class)->expects('compile');
        $this->mock(ConnectionInterface::class);
        $this->mock(UpdateAction::class)->expects('__invoke');
        $executor = $this->app->make(BladeSQLExecutor::class);

        $this->assertIsInt($executor->update('blade-name', []));
    }
}
