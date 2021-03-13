<?php

namespace Schrosis\BladeSQL\Tests\Unit\UseCase;

use Illuminate\Database\ConnectionInterface;
use Mockery\MockInterface;
use Schrosis\BladeSQL\BladeSQL\Domain\Entity\Query;
use Schrosis\BladeSQL\BladeSQL\UseCase\UpdateAction;
use Schrosis\BladeSQL\Tests\TestCase;

class UpdateActionTest extends TestCase
{
    public function testInvoke()
    {
        $this->mock(ConnectionInterface::class)
            ->expects('update')
            ->andReturn(1);
        $this->mock(Query::class, function(MockInterface $mock) {
            $mock->expects('getSQL')
                ->andReturn('select query string');
            $mock->expects('getParams')
                ->andReturn(['query params']);
        });

        $useCase = new UpdateAction();
        $connection = $this->app->make(ConnectionInterface::class);
        $query = $this->app->make(Query::class);

        $this->assertSame(1, $useCase->__invoke($connection, $query));
    }
}
