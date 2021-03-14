<?php

namespace Schrosis\BladeSQL\BladeSQL;

use Illuminate\Support\Facades\View;
use Schrosis\BladeSQL\BladeSQL\Contracts\Compiler;
use Schrosis\BladeSQL\BladeSQL\Domain\Entity\Query;
use Schrosis\BladeSQL\BladeSQL\UseCase\CompileAction;
use Schrosis\BladeSQL\BladeSQL\UseCase\ConvertNamedToQuestionAction;

class BladeSQLCompiler implements Compiler
{
    /**
     * @var \Schrosis\BladeSQL\BladeSQL\UseCase\CompileAction
     */
    protected $compileAction;
    /**
     * @var \Schrosis\BladeSQL\BladeSQL\UseCase\ConvertNamedToQuestionAction
     */
    protected $convertAction;

    public function __construct(
        CompileAction $compileAction,
        ConvertNamedToQuestionAction $convertAction
    ) {
        $this->compileAction = $compileAction;
        $this->convertAction = $convertAction;
    }

    /**
     * compile the blade and return the SQL and query parameters
     *
     * @param string $blade
     * @param array $params
     * @return \Schrosis\BladeSQL\BladeSQL\Domain\Entity\Query
     */
    public function compile(string $blade, array $params = []): Query
    {
        $namedPlaceholderQuery = $this->compileAction->__invoke(
            View::make('sql::'.$blade),
            $params
        );

        return $this->convertAction->__invoke($namedPlaceholderQuery);
    }
}
