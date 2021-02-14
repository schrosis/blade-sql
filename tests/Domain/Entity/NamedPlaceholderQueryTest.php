<?php

namespace Schrosis\BladeSQL\Tests\Domain\Entity;

use Schrosis\BladeSQL\BladeSQL\Domain\Entity\NamedPlaceholderQuery;
use Schrosis\BladeSQL\BladeSQL\Domain\ValueObject\NamedPlaceholderSQL;
use Schrosis\BladeSQL\BladeSQL\Domain\ValueObject\NamedPlaceholderSQLParameters;
use Schrosis\BladeSQL\Tests\TestCase;

class NamedPlaceholderQueryTest extends TestCase
{
    public function testGetNamedPlaceholderSQL()
    {
        $sql = new NamedPlaceholderSQL('sql string');
        $query = new NamedPlaceholderQuery(
            $sql,
            new NamedPlaceholderSQLParameters([])
        );

        $this->assertSame($sql, $query->getNamedPlaceholderSQL());
    }

    public function testGetSQL()
    {
        $sql = new NamedPlaceholderSQL('sql string');
        $query = new NamedPlaceholderQuery(
            $sql,
            new NamedPlaceholderSQLParameters([])
        );

        $this->assertSame('sql string', $query->getSQL());
    }

    public function testGetNamedPlaceholderSQLParameters()
    {
        $params = new NamedPlaceholderSQLParameters([
            'named_param' => 1,
            'question mark param value',
        ]);
        $query = new NamedPlaceholderQuery(
            new NamedPlaceholderSQL(''),
            $params
        );

        $this->assertSame($params, $query->getNamedPlaceholderSQLParameters());
    }

    public function testGetParams()
    {
        $params = new NamedPlaceholderSQLParameters([
            'named_param' => 1,
            'question mark param value',
        ]);
        $query = new NamedPlaceholderQuery(
            new NamedPlaceholderSQL(''),
            $params
        );

        $this->assertSame(
            [
                'named_param' => 1,
                'question mark param value',
            ],
            $query->getParams()
        );
    }
}
