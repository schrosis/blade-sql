<?php

namespace Schrosis\BladeSQL\BladeSQL\Contracts;

use Schrosis\BladeSQL\BladeSQL\Domain\Entity\Query;
use Schrosis\BladeSQL\BladeSQL\SelectResultCollection;

interface Executor
{
    /**
     * execute select query with blade
     *
     * @param string $blade
     * @param array $queryParams
     * @return \Schrosis\BladeSQL\BladeSQL\SelectResultCollection
     */
    public function select(string $blade, array $queryParams = []): SelectResultCollection;

    /**
     * execute insert query with blade
     *
     * @param string $blade
     * @param array $queryParams
     * @return int
     */
    public function insert(string $blade, array $queryParams = []): int;

    /**
     * execute update query with blade
     *
     * @param string $blade
     * @param array $queryParams
     * @return int
     */
    public function update(string $blade, array $queryParams = []): int;

    /**
     * execute delete query with blade
     *
     * @param string $blade
     * @param array $queryParams
     * @return int
     */
    public function delete(string $blade, array $queryParams = []): int;

    /**
     * compile the blade and return the SQL and query parameters
     *
     * @param string $blade
     * @param array $queryParams
     * @return \Schrosis\BladeSQL\BladeSQL\Domain\Entity\Query
     */
    public function compile(string $blade, array $queryParams = []): Query;

    /**
     * escape the string used in the like clause
     *
     * @param string $keyword
     * @return string
     */
    public function likeEscape(string $keyword): string;

    /**
     * set the connection
     *
     * @param \Illuminate\Database\ConnectionInterface|string|null $connection
     * @return \Schrosis\BladeSQL\BladeSQL\Contracts\Executor
     */
    public function setConnection($connection);
}
