<?php

namespace Schrosis\BladeSQL\Tests\Unit\UseCase;

use Illuminate\Database\ConnectionInterface;
use Mockery\MockInterface;
use Schrosis\BladeSQL\BladeSQL\Domain\Entity\Query;
use Schrosis\BladeSQL\BladeSQL\SelectResultCollection;
use Schrosis\BladeSQL\BladeSQL\UseCase\SelectAction;
use Schrosis\BladeSQL\Tests\TestCase;

class SekectActionTest extends TestCase
{
    public function testInvoke()
    {
        $this->mock(ConnectionInterface::class)
            ->expects('select');
        $this->mock(Query::class, function(MockInterface $mock) {
            $mock->expects('getSQL')
                ->andReturn('select query string');
            $mock->expects('getParams')
                ->andReturn(['query params']);
        });

        $useCase = new SelectAction();
        $connection = $this->app->make(ConnectionInterface::class);
        $query = $this->app->make(Query::class);

        $this->assertInstanceOf(
            SelectResultCollection::class,
            $useCase->__invoke($connection, $query)
        );
    }
}
