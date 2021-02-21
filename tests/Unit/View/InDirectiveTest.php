<?php

namespace Schrosis\BladeSQL\Tests\Unit\View;

use RuntimeException;
use Schrosis\BladeSQL\BladeSQL\Domain\ValueObject\NamedPlaceholderParameters;
use Schrosis\BladeSQL\BladeSQL\View\Directives\InDirective;
use Schrosis\BladeSQL\Tests\TestCase;

class InDirectiveTest extends TestCase
{
    public function testName()
    {
        $this->assertSame('IN', InDirective::NAME);
    }

    public function testProcess()
    {
        $processString = InDirective::process('key');

        $this->assertSame(
            "<?= ".InDirective::class."::compile(\$__bladesqlparams, 'key', \$key) ?>\n",
            $processString
        );
    }

    public function testCompile()
    {
        $oneElement = InDirective::compile(new NamedPlaceholderParameters([]), 'key', ['value']);
        $this->assertSame('= :bladesql_in_key_0', $oneElement);

        $manyElement = InDirective::compile(new NamedPlaceholderParameters([]), 'key', ['value1', 'value2']);
        $this->assertSame('IN(:bladesql_in_key_0, :bladesql_in_key_1)', $manyElement);
    }

    public function testThrowExceptionWhenEmptyArray()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The number of elements in the in clause is zero. Enclose it in an if directive');

        InDirective::compile(new NamedPlaceholderParameters([]), 'key', []);
    }
}
