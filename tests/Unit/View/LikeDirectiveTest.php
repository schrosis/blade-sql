<?php

namespace Schrosis\BladeSQL\Tests\Unit\View;

use Schrosis\BladeSQL\BladeSQL\Domain\ValueObject\NamedPlaceholderParameters;
use Schrosis\BladeSQL\BladeSQL\UseCase\CompileWhereLikeAction;
use Schrosis\BladeSQL\BladeSQL\View\Directives\LikeDirective;
use Schrosis\BladeSQL\Tests\TestCase;

class LikeDirectiveTest extends TestCase
{
    public function testProcess()
    {
        $this->assertSame(
            "<?= ".LikeDirective::class."::compile(\$__bladesqlparams, 'keyword', \$keyword, '', '') ?>\n",
            LikeDirective::process('keyword')
        );
        $this->assertSame(
            "<?= ".LikeDirective::class."::compile(\$__bladesqlparams, 'keyword', \$keyword, '', '') ?>\n",
            LikeDirective::process('{keyword}')
        );
        $this->assertSame(
            "<?= ".LikeDirective::class."::compile(\$__bladesqlparams, 'keyword', \$keyword, '%', '_') ?>\n",
            LikeDirective::process('%{keyword}_')
        );
    }

    public function testCompile()
    {
        $this->mock(CompileWhereLikeAction::class)
            ->shouldReceive('__invoke')
            ->withArgs(['key', 'keyword', '', '%'])
            ->andReturn(['bladesql_like_key_01', 'keyword%']);

        $this->mock(NamedPlaceholderParameters::class)
            ->shouldReceive('setValue')
            ->withArgs(['bladesql_like_key_01', 'keyword%']);
        $params = $this->app->make(NamedPlaceholderParameters::class);

        $likestm = LikeDirective::compile($params, 'key', 'keyword', '', '%');

        $this->assertSame("LIKE :bladesql_like_key_01 ESCAPE '\\'", $likestm);
    }
}
