<?php

namespace Schrosis\BladeSQL\BladeSQL;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Facades\DB;
use Schrosis\BladeSQL\BladeSQL\Contracts\Compiler;
use Schrosis\BladeSQL\BladeSQL\Contracts\Executor;
use Schrosis\BladeSQL\BladeSQL\Domain\Entity\Query;
use Schrosis\BladeSQL\BladeSQL\UseCase\LikeEscapeAction;

class BladeSQLExecutor implements Executor
{
    /**
     * database connection name
     *
     * @var ConnectionInterface|string|null
     */
    private $connection;

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

    /**
     * set connection
     *
     * @param ConnectionInterface|string|null $connection
     * @return Executor
     */
    public function setConnection($connection): Executor
    {
        $this->connection = $connection;
        return $this;
    }

    protected function getConnection(): ConnectionInterface
    {
        if ($this->connection instanceof ConnectionInterface) {
            return $this->connection;
        }
        return DB::connection($this->connection);
    }

    public function select(string $blade, array $queryParams = []): SelectResultCollection
    {
        $query = $this->compile($blade, $queryParams);
        $result = $this->getConnection()->select($query->getSQL(), $query->getParams());

        return new SelectResultCollection($result);
    }
}
