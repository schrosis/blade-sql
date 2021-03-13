<?php

namespace Schrosis\BladeSQL\BladeSQL;

use Illuminate\Container\Container;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Facades\DB;
use Schrosis\BladeSQL\BladeSQL\Contracts\Compiler;
use Schrosis\BladeSQL\BladeSQL\Contracts\Executor;
use Schrosis\BladeSQL\BladeSQL\Domain\Entity\Query;
use Schrosis\BladeSQL\BladeSQL\UseCase\LikeEscapeAction;
use Schrosis\BladeSQL\BladeSQL\UseCase\SelectAction;
use Schrosis\BladeSQL\BladeSQL\UseCase\UpdateAction;

class BladeSQLExecutor implements Executor
{
    /**
     * database connection name
     *
     * @var ConnectionInterface|string|null
     */
    private $connection;

    /**
     * service container
     *
     * @var Container
     */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function compile(string $blade, array $queryParams = []): Query
    {
        /** @var Compiler */
        $compiler = $this->container->make(Compiler::class);

        return $compiler->compile($blade, $queryParams);
    }

    public function likeEscape(string $keyword): string
    {
        /** @var LikeEscapeAction */
        $likeEscapeAction = $this->container->make(LikeEscapeAction::class);

        return $likeEscapeAction($keyword);
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
        /** @var SelectAction */
        $selectAction = $this->container->make(SelectAction::class);

        return $selectAction(
            $this->getConnection(),
            $this->compile($blade, $queryParams)
        );
    }

    public function update(string $blade, array $queryParams = []): int
    {
        /** @var UpdateAction */
        $updateAction = $this->container->make(UpdateAction::class);

        return $updateAction(
            $this->getConnection(),
            $this->compile($blade, $queryParams)
        );
    }
}
