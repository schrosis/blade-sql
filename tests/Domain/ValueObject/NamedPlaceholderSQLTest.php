<?php

namespace Schrosis\BladeSQL\Tests\Domain\ValueObject;

use Schrosis\BladeSQL\BladeSQL\Domain\ValueObject\NamedPlaceholderSQL;
use Schrosis\BladeSQL\Tests\TestCase;

class NamedPlaceholderSQLTest extends TestCase
{
    public function testGetValue()
    {
        $sql = new NamedPlaceholderSQL('sql string');
        $this->assertSame('sql string', $sql->getValue());
    }
}
