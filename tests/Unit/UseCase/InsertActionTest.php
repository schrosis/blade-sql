<?php

namespace Schrosis\BladeSQL\Tests\Unit\UseCase;

use Illuminate\Database\ConnectionInterface;
use Mockery\MockInterface;
use Schrosis\BladeSQL\BladeSQL\Domain\Entity\Query;
use Schrosis\BladeSQL\BladeSQL\UseCase\InsertAction;
use Schrosis\BladeSQL\Tests\TestCase;

class InsertActionTest extends TestCase
{
    public function testInvoke()
    {
        $this->mock(ConnectionInterface::class)
            ->expects('insert')
            ->andReturn(1);
        $this->mock(Query::class, function(MockInterface $mock) {
            $mock->expects('getSQL')
                ->andReturn('select query string');
            $mock->expects('getParams')
                ->andReturn(['query params']);
        });

        $useCase = new InsertAction();
        $connection = $this->app->make(ConnectionInterface::class);
        $query = $this->app->make(Query::class);

        $this->assertSame(1, $useCase->__invoke($connection, $query));
    }
}
