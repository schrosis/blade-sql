<?php

namespace Schrosis\BladeSQL\BladeSQL;

use Illuminate\Support\Facades\View;
use Schrosis\BladeSQL\BladeSQL\Contracts\Compiler;
use Schrosis\BladeSQL\BladeSQL\Domain\Entity\Query;
use Schrosis\BladeSQL\BladeSQL\UseCase\CompileAction;

class BladeSQLCompiler implements Compiler
{
    /**
     * @var CompileAction
     */
    protected $compileAction;

    public function __construct(CompileAction $compileAction)
    {
        $this->compileAction = $compileAction;
    }

    public function compile(string $blade, array $params = []): Query
    {
        $namedPlaceholderQuery = $this->compileAction->__invoke(
            View::make('sql::'.$blade),
            $params
        );

        return $namedPlaceholderQuery;
    }
}
