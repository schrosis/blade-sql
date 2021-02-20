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
        return new NamedPlaceholderQuery(
            $this->compileSQL($view, $params),
            $this->compileParams($params)
        );
    }

    protected function compileSQL(View $view, array $params): NamedPlaceholderSQL
    {
        return new NamedPlaceholderSQL(
            $view->with($params)->render()
        );
    }

    protected function compileParams(array $params): NamedPlaceholderParameters
    {
        $compiledParams = [];
        foreach ($params as $key => $value) {
            switch (true) {
                case is_scalar($value):
                case is_null($value):
                    $compiledParams[$key] = $value;
                    break;
                case is_array($value):
                    $compiledParams += $this->compileWhereInAction->__invoke($key, $value);
                    break;
                default:
                    throw new RuntimeException('Only null or scalar or scalar array are allowed');
            }
        }
        return new NamedPlaceholderParameters($compiledParams);
    }
}
