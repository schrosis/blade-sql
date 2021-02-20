<?php

namespace Schrosis\BladeSQL\Tests\Unit\UseCase;

use RuntimeException;
use Schrosis\BladeSQL\BladeSQL\Domain\Entity\NamedPlaceholderQuery;
use Schrosis\BladeSQL\BladeSQL\Domain\Entity\QuestionMarkPlaceholderQuery;
use Schrosis\BladeSQL\BladeSQL\Domain\ValueObject\NamedPlaceholderParameters;
use Schrosis\BladeSQL\BladeSQL\Domain\ValueObject\NamedPlaceholderSQL;
use Schrosis\BladeSQL\BladeSQL\UseCase\ConvertNamedToQuestionAction;
use Schrosis\BladeSQL\Tests\TestCase;

class ConvertNamedToQuestionActionTest extends TestCase
{
    public function testInvoke()
    {
        $useCase = new ConvertNamedToQuestionAction();

        $named = new NamedPlaceholderQuery(
            new NamedPlaceholderSQL('SELECT * FROM users WHERE id IN(:id_1, :id_2)'),
            new NamedPlaceholderParameters(['id_1' => 1, 'id_2' => 2])
        );

        $questionMarkQuery = $useCase->__invoke($named);

        $this->assertInstanceOf(QuestionMarkPlaceholderQuery::class, $questionMarkQuery);

        $this->assertSame(
            'SELECT * FROM users WHERE id IN(?, ?)',
            $questionMarkQuery->getSQL()
        );

        $this->assertSame(
            [1, 2],
            $questionMarkQuery->getParams()
        );
    }

    public function testThrowExceptionWhenParamsDoesntHaveKey()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessageMatches('/key \[[a-zA-z0-9_]+\] does not exist in params/');

        $named = new NamedPlaceholderQuery(
            new NamedPlaceholderSQL(':param_1'),
            new NamedPlaceholderParameters(['other_param_1' => 1, 'other_param_2' => 2])
        );

        $useCase = new ConvertNamedToQuestionAction();
        $useCase->__invoke($named);
    }
}
