<?php

namespace Schrosis\BladeSQL\Tests\Unit\Domain\ValueObject;

use Schrosis\BladeSQL\BladeSQL\Domain\ValueObject\NamedPlaceholderParameters;
use Schrosis\BladeSQL\Tests\TestCase;

class NamedPlaceholderParametersTest extends TestCase
{
    public function testGetValue()
    {
        $params = new NamedPlaceholderParameters([
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
