<?php

namespace Schrosis\BladeSQL\Tests\Domain\ValueObject;

use Schrosis\BladeSQL\BladeSQL\Domain\ValueObject\NamedPlaceholderSQLParameters;
use Schrosis\BladeSQL\Tests\TestCase;

class NamedPlaceholderSQLParametersTest extends TestCase
{
    public function testGetValue()
    {
        $params = new NamedPlaceholderSQLParameters([
            'named_param' => 1,
            'question mark param value',
        ]);

        $this->assertSame(
            [
                'named_param' => 1,
                'question mark param value',
            ],
            $params->getValue()
        );
    }
}
