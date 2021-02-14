<?php

namespace Schrosis\BladeSQL\Tests\UseCase;

use RuntimeException;
use Schrosis\BladeSQL\BladeSQL\UseCase\CompileWhereInAction;
use Schrosis\BladeSQL\Tests\TestCase;

class CompileWhereInActionTest extends TestCase
{
    public function testInvoke()
    {
        $useCase = new CompileWhereInAction();

        $this->assertEquals(
            [
                'bladesql_in_key_0' => 'a',
                'bladesql_in_key_1' => 1,
                'bladesql_in_key_2' => 0.1,
                'bladesql_in_key_3' => true,
            ],
            $useCase('key', ['a', 1, 0.1, true])
        );
    }

    public function testForNamedPlaceholder()
    {
        $useCase = new CompileWhereInAction();

        $this->assertEquals(
            [
                ':bladesql_in_key_0',
                ':bladesql_in_key_1',
                ':bladesql_in_key_2',
                ':bladesql_in_key_3',
            ],
            $useCase->forNamedPlaceholder('key', ['a', 1, 0.1, true])
        );
    }

    public function testThrowExceptionWhenIntKey()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Only string are allowed as array value keys');

        $useCase = new CompileWhereInAction();
        $useCase(0, []);
    }

    public function testThrowExceptionWhenContainsNull()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Only scalar array are allowed');

        $useCase = new CompileWhereInAction();
        $useCase('key', [null]);
    }

    public function testThrowExceptionWhenContainsArray()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Only scalar array are allowed');

        $useCase = new CompileWhereInAction();
        $useCase('key', [[]]);
    }

    public function testThrowExceptionWhenContainsObject()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Only scalar array are allowed');

        $useCase = new CompileWhereInAction();
        $useCase('key', [(object)[]]);
    }
}
