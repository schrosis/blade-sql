<?php

namespace Schrosis\BladeSQL\BladeSQL\UseCase;

use RuntimeException;
use Schrosis\BladeSQL\Tests\TestCase;

class CompileWhereLikeActionTest extends TestCase
{
    public function testInvoke()
    {
        $this->mock(LikeEscapeAction::class)->shouldReceive('__invoke');
        $useCase = $this->app->make(CompileWhereLikeAction::class);

        [$key, $value] = $useCase('key', 'value', '', '');
        $this->assertSame('bladesql_like_key_00', $key);

        [$key, $value] = $useCase('key', 'value', '%', '_');
        $this->assertSame('bladesql_like_key_12', $key);
    }

    public function testThrowExceptionWhenInvalidCharacter()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('invalid character. allowed % or _');

        $this->mock(LikeEscapeAction::class)->shouldReceive('__invoke');
        $useCase = $this->app->make(CompileWhereLikeAction::class);

        $useCase('key', 'value', 'invalid', 'character');
    }
}
