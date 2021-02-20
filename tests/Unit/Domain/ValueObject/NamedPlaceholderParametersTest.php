<?php

namespace Schrosis\BladeSQL\Tests\Unit\Domain\ValueObject;

use Schrosis\BladeSQL\BladeSQL\Domain\ValueObject\NamedPlaceholderParameters;
use Schrosis\BladeSQL\Tests\TestCase;

class NamedPlaceholderParametersTest extends TestCase
{
    public function testGetValue()
    {
        $params = new NamedPlaceholderParameters([
            'named_param1' => 1,
            'named_param2' => 2,
        ]);

        $this->assertSame(
            [
                'named_param1' => 1,
                'named_param2' => 2,
            ],
            $params->getValue()
        );
    }
}
