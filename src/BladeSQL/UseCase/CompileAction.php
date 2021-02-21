<?php

namespace Schrosis\BladeSQL\BladeSQL\UseCase;

use Illuminate\Contracts\View\View;
use RuntimeException;
use Schrosis\BladeSQL\BladeSQL\Domain\Entity\NamedPlaceholderQuery;
use Schrosis\BladeSQL\BladeSQL\Domain\ValueObject\NamedPlaceholderSQL;
use Schrosis\BladeSQL\BladeSQL\Domain\ValueObject\NamedPlaceholderParameters;

class CompileAction
{
    /**
     * @var CompileWhereInAction
     */
    private $compileWhereInAction;

    public function __construct(CompileWhereInAction $compileWhereInAction)
    {
        $this->compileWhereInAction = $compileWhereInAction;
    }

    public function __invoke(View $view, array $params): NamedPlaceholderQuery
    {
        $__bladesqlparams = new NamedPlaceholderParameters($params);
        $params['__bladesqlparams'] = $__bladesqlparams;

        $sql = $this->compileSQL($view, $params);

        return new NamedPlaceholderQuery(
            $sql,
            $__bladesqlparams
        );
    }

    protected function compileSQL(View $view, array $params): NamedPlaceholderSQL
    {
        return new NamedPlaceholderSQL(
            $view->with($params)->render()
        );
    }
}
