<?php

namespace Schrosis\BladeSQL\BladeSQL;

use Schrosis\BladeSQL\BladeSQL\Contracts\Compiler;
use Schrosis\BladeSQL\BladeSQL\Contracts\Executor;
use Schrosis\BladeSQL\BladeSQL\Domain\Entity\Query;

class BladeSQLExecutor implements Executor
{
    /**
     * BladeSQL compiler
     *
     * @var Compiler
     */
    private $compiler;

    public function __construct(Compiler $compiler)
    {
        $this->compiler = $compiler;
    }

    public function compile(string $blade, array $queryParams = []): Query
    {
        return $this->compiler->compile($blade, $queryParams);
    }
}
