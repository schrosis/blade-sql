<?php

namespace Schrosis\BladeSQL\Tests\Unit\UseCase;

use Schrosis\BladeSQL\BladeSQL\UseCase\LikeEscapeAction;
use Schrosis\BladeSQL\Tests\TestCase;

class LikeEscapeActionTest extends TestCase
{
    public function testInvoke()
    {
        $useCase = new LikeEscapeAction();

        $this->assertSame('keyword', $useCase('keyword'));
        $this->assertSame('keywor\%d', $useCase('keywor%d'));
        $this->assertSame('key\_word', $useCase('key_word'));
        $this->assertSame('k\\\\eyword', $useCase('k\\eyword'));
    }
}
