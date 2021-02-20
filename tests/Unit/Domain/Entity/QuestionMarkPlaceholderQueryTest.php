<?php

namespace Schrosis\BladeSQL\Tests\Unit\Domain\Entity;

use Schrosis\BladeSQL\BladeSQL\Domain\Entity\QuestionMarkPlaceholderQuery;
use Schrosis\BladeSQL\BladeSQL\Domain\ValueObject\QuestionMarkPlaceholderParameters;
use Schrosis\BladeSQL\BladeSQL\Domain\ValueObject\QuestionMarkPlaceholderSQL;
use Schrosis\BladeSQL\Tests\TestCase;

class QuestionMarkPlaceholderQueryTest extends TestCase
{
    public function testGetNamedPlaceholderSQL()
    {
        $sql = new QuestionMarkPlaceholderSQL('sql string');
        $query = new QuestionMarkPlaceholderQuery(
            $sql,
            new QuestionMarkPlaceholderParameters([])
        );

        $this->assertSame($sql, $query->getQuestionMarkPlaceholderSQL());
    }

    public function testGetSQL()
    {
        $sql = new QuestionMarkPlaceholderSQL('sql string');
        $query = new QuestionMarkPlaceholderQuery(
            $sql,
            new QuestionMarkPlaceholderParameters([])
        );

        $this->assertSame('sql string', $query->getSQL());
    }

    public function testGetNamedPlaceholderParameters()
    {
        $params = new QuestionMarkPlaceholderParameters([
            'value1',
            'value2',
        ]);
        $query = new QuestionMarkPlaceholderQuery(
            new QuestionMarkPlaceholderSQL(''),
            $params
        );

        $this->assertSame($params, $query->getQuestionMarkPlaceholderParameters());
    }

    public function testGetParams()
    {
        $params = new QuestionMarkPlaceholderParameters([
            'value1',
            'value2',
        ]);
        $query = new QuestionMarkPlaceholderQuery(
            new QuestionMarkPlaceholderSQL(''),
            $params
        );

        $this->assertSame(
            [
                'value1',
                'value2',
            ],
            $query->getParams()
        );
    }
}
