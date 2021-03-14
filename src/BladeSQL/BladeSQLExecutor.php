<?php

namespace Schrosis\BladeSQL\BladeSQL;

use Illuminate\Container\Container;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Facades\DB;
use Schrosis\BladeSQL\BladeSQL\Contracts\Compiler;
use Schrosis\BladeSQL\BladeSQL\Contracts\Executor;
use Schrosis\BladeSQL\BladeSQL\Domain\Entity\Query;
use Schrosis\BladeSQL\BladeSQL\UseCase\DeleteAction;
use Schrosis\BladeSQL\BladeSQL\UseCase\InsertAction;
use Schrosis\BladeSQL\BladeSQL\UseCase\LikeEscapeAction;
use Schrosis\BladeSQL\BladeSQL\UseCase\SelectAction;
use Schrosis\BladeSQL\BladeSQL\UseCase\UpdateAction;

class BladeSQLExecutor implements Executor
{
    /**
     * database connection name
     *
     * @var \Illuminate\Database\ConnectionInterface|string|null
     */
    private $connection;

    /**
     * service container
     *
     * @var \Illuminate\Container\Container
     */
    private $container;

    /**
     * @param \Illuminate\Container\Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * execute select query with blade
     *
     * @param string $blade
     * @param array $queryParams
     * @return \Schrosis\BladeSQL\BladeSQL\SelectResultCollection
     */
    public function select(string $blade, array $queryParams = []): SelectResultCollection
    {
        /** @var SelectAction */
        $selectAction = $this->container->make(SelectAction::class);

        return $selectAction(
            $this->getConnection(),
            $this->compile($blade, $queryParams)
        );
    }

    /**
     * execute insert query with blade
     *
     * @param string $blade
     * @param array $queryParams
     * @return int
     */
    public function insert(string $blade, array $queryParams = []): int
    {
        /** @var InsertAction */
        $insertAction = $this->container->make(InsertAction::class);

        return $insertAction(
            $this->getConnection(),
            $this->compile($blade, $queryParams)
        );
    }

    /**
     * execute update query with blade
     *
     * @param string $blade
     * @param array $queryParams
     * @return int
     */
    public function update(string $blade, array $queryParams = []): int
    {
        /** @var UpdateAction */
        $updateAction = $this->container->make(UpdateAction::class);

        return $updateAction(
            $this->getConnection(),
            $this->compile($blade, $queryParams)
        );
    }

    /**
     * execute delete query with blade
     *
     * @param string $blade
     * @param array $queryParams
     * @return int
     */
    public function delete(string $blade, array $queryParams = []): int
    {
        /** @var DeleteAction */
        $deleteAction = $this->container->make(DeleteAction::class);

        return $deleteAction(
            $this->getConnection(),
            $this->compile($blade, $queryParams)
        );
    }

    /**
     * compile the blade and return the SQL and query parameters
     *
     * @param string $blade
     * @param array $queryParams
     * @return \Schrosis\BladeSQL\BladeSQL\Domain\Entity\Query
     */
    public function compile(string $blade, array $queryParams = []): Query
    {
        /** @var Compiler */
        $compiler = $this->container->make(Compiler::class);

        return $compiler->compile($blade, $queryParams);
    }

    /**
     * escape the string used in the like clause
     *
     * @param string $keyword
     * @return string
     */
    public function likeEscape(string $keyword): string
    {
        /** @var LikeEscapeAction */
        $likeEscapeAction = $this->container->make(LikeEscapeAction::class);

        return $likeEscapeAction($keyword);
    }

    /**
     * set the connection
     *
     * @param \Illuminate\Database\ConnectionInterface|string|null $connection
     * @return \Schrosis\BladeSQL\BladeSQL\Contracts\Executor
     */
    public function setConnection($connection): Executor
    {
        $this->connection = $connection;
        return $this;
    }

    /**
     * get the connection
     *
     * @return \Illuminate\Database\ConnectionInterface
     */
    protected function getConnection(): ConnectionInterface
    {
        if ($this->connection instanceof ConnectionInterface) {
            return $this->connection;
        }
        return DB::connection($this->connection);
    }
}
