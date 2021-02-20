<?php

namespace Schrosis\BladeSQL\Tests\Unit\Domain\Entity;

use Schrosis\BladeSQL\BladeSQL\Domain\Entity\NamedPlaceholderQuery;
use Schrosis\BladeSQL\BladeSQL\Domain\ValueObject\NamedPlaceholderSQL;
use Schrosis\BladeSQL\BladeSQL\Domain\ValueObject\NamedPlaceholderParameters;
use Schrosis\BladeSQL\Tests\TestCase;

class NamedPlaceholderQueryTest extends TestCase
{
    public function testGetNamedPlaceholderSQL()
    {
        $sql = new NamedPlaceholderSQL('sql string');
        $query = new NamedPlaceholderQuery(
            $sql,
            new NamedPlaceholderParameters([])
        );

        $this->assertSame($sql, $query->getNamedPlaceholderSQL());
    }

    public function testGetSQL()
    {
        $sql = new NamedPlaceholderSQL('sql string');
        $query = new NamedPlaceholderQuery(
            $sql,
            new NamedPlaceholderParameters([])
        );

        $this->assertSame('sql string', $query->getSQL());
    }

    public function testGetNamedPlaceholderParameters()
    {
        $params = new NamedPlaceholderParameters([
            'named_param' => 1,
            'question mark param value',
        ]);
        $query = new NamedPlaceholderQuery(
            new NamedPlaceholderSQL(''),
            $params
        );

        $this->assertSame($params, $query->getNamedPlaceholderParameters());
    }

    public function testGetParams()
    {
        $params = new NamedPlaceholderParameters([
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
