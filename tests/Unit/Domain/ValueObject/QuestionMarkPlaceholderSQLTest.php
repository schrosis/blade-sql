<?php

namespace Schrosis\BladeSQL\Tests\Unit\Domain\ValueObject;

use Schrosis\BladeSQL\BladeSQL\Domain\ValueObject\QuestionMarkPlaceholderSQL;
use Schrosis\BladeSQL\Tests\TestCase;

class QuestionMarkPlaceholderSQLTest extends TestCase
{
    public function testGetValue()
    {
        $sql = new QuestionMarkPlaceholderSQL('sql string');
        $this->assertSame('sql string', $sql->getValue());
    }
}
