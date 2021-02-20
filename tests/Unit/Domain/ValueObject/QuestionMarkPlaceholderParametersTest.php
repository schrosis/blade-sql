<?php

namespace Schrosis\BladeSQL\Tests\Unit\Domain\ValueObject;

use Schrosis\BladeSQL\BladeSQL\Domain\ValueObject\QuestionMarkPlaceholderParameters;
use Schrosis\BladeSQL\Tests\TestCase;

class QuestionMarkPlaceholderParametersTest extends TestCase
{
    public function testGetValue()
    {
        $params = new QuestionMarkPlaceholderParameters([
            'value1',
            'value2',
        ]);

        $this->assertSame(
            [
                'value1',
                'value2',
            ],
            $params->getValue()
        );
    }
}
