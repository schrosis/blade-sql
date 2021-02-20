<?php

namespace Schrosis\BladeSQL\Tests\Unit;

use Illuminate\Contracts\View\View;
use Schrosis\BladeSQL\BladeSQL\BladeSQLCompiler;
use Schrosis\BladeSQL\BladeSQL\Domain\Entity\NamedPlaceholderQuery;
use Schrosis\BladeSQL\BladeSQL\Domain\Entity\Query;
use Schrosis\BladeSQL\BladeSQL\Domain\Entity\QuestionMarkPlaceholderQuery;
use Schrosis\BladeSQL\BladeSQL\Domain\ValueObject\NamedPlaceholderParameters;
use Schrosis\BladeSQL\BladeSQL\Domain\ValueObject\NamedPlaceholderSQL;
use Schrosis\BladeSQL\BladeSQL\Domain\ValueObject\QuestionMarkPlaceholderParameters;
use Schrosis\BladeSQL\BladeSQL\Domain\ValueObject\QuestionMarkPlaceholderSQL;
use Schrosis\BladeSQL\BladeSQL\UseCase\CompileAction;
use Schrosis\BladeSQL\BladeSQL\UseCase\ConvertNamedToQuestionAction;
use Schrosis\BladeSQL\Tests\TestCase;

class BladeSQLCompilerTest extends TestCase
{
    public function testCompile()
    {
        $blade = 'blade.file.name';
        $params = [
            'array_key' => [1, 2, 3],
            'other_param1' => 'test',
            'other_param2' => null,
        ];
        $view = $this->mock(View::class);

        $this->mock('view')
            ->shouldReceive('make')
            ->withArgs(['sql::'.$blade])
            ->andReturn($view);

        $namedPlaceholderQuery = new NamedPlaceholderQuery(
            new NamedPlaceholderSQL('SELECT * FROM users WHERE id = :id'),
            new NamedPlaceholderParameters(['id' => 1])
        );

        $this->mock(CompileAction::class)
            ->shouldReceive('__invoke')
            ->withArgs([$view, $params])
            ->andReturn($namedPlaceholderQuery);

        $this->mock(ConvertNamedToQuestionAction::class)
            ->shouldReceive('__invoke')
            ->withArgs([$namedPlaceholderQuery])
            ->andReturn(new QuestionMarkPlaceholderQuery(
                new QuestionMarkPlaceholderSQL('SELECT * FROM users WHERE id = ?'),
                new QuestionMarkPlaceholderParameters([1])
            ));

        $compiler = $this->app->make(BladeSQLCompiler::class);

        $query = $compiler->compile($blade, $params);
        $this->assertInstanceOf(Query::class, $query);
    }
}
