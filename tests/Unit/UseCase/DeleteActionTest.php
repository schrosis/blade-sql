<?php

namespace Schrosis\BladeSQL\Tests\Unit\UseCase;

use Illuminate\Database\ConnectionInterface;
use Mockery\MockInterface;
use Schrosis\BladeSQL\BladeSQL\Domain\Entity\Query;
use Schrosis\BladeSQL\BladeSQL\UseCase\DeleteAction;
use Schrosis\BladeSQL\Tests\TestCase;

class DeleteActionTest extends TestCase
{
    public function testInvoke()
    {
        $this->mock(ConnectionInterface::class)
            ->expects('delete')
            ->andReturn(1);
        $this->mock(Query::class, function(MockInterface $mock) {
            $mock->expects('getSQL')
                ->andReturn('select query string');
            $mock->expects('getParams')
                ->andReturn(['query params']);
        });

        $useCase = new DeleteAction();
        $connection = $this->app->make(ConnectionInterface::class);
        $query = $this->app->make(Query::class);

        $this->assertSame(1, $useCase->__invoke($connection, $query));
    }
}
