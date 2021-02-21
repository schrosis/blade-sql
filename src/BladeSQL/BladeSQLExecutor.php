<?php

namespace Schrosis\BladeSQL\BladeSQL;

use Schrosis\BladeSQL\BladeSQL\Contracts\Compiler;
use Schrosis\BladeSQL\BladeSQL\Contracts\Executor;
use Schrosis\BladeSQL\BladeSQL\Domain\Entity\Query;
use Schrosis\BladeSQL\BladeSQL\UseCase\LikeEscapeAction;

class BladeSQLExecutor implements Executor
{
    /**
     * BladeSQL compiler
     *
     * @var Compiler
     */
    private $compiler;

    /**
     * like escape action
     *
     * @var LikeEscapeAction
     */
    private $likeEscapeAction;

    public function __construct(Compiler $compiler, LikeEscapeAction $likeEscapeAction)
    {
        $this->compiler = $compiler;
        $this->likeEscapeAction = $likeEscapeAction;
    }

    public function compile(string $blade, array $queryParams = []): Query
    {
        return $this->compiler->compile($blade, $queryParams);
    }

    public function likeEscape(string $keyword): string
    {
        return $this->likeEscapeAction->__invoke($keyword);
    }

}
