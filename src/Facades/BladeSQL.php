<?php

namespace Schrosis\BladeSQL\Facades;

use Illuminate\Support\Facades\Facade;
use Schrosis\BladeSQL\BladeSQL\Contracts\Executor;

/**
 * @method static \Schrosis\BladeSQL\BladeSQL\SelectResultCollection select(string $blade, array $queryParams = []) execute select query with blade
 * @method static int insert(string $blade, array $queryParams = []) execute insert query with blade
 * @method static int update(string $blade, array $queryParams = []) execute update query with blade
 * @method static int delete(string $blade, array $queryParams = []) execute delete query with blade
 * @method static \Schrosis\BladeSQL\BladeSQL\Domain\Entity\Query compile(string $blade, array $queryParams = []) compile the blade and return the SQL and query parameters
 * @method static string likeEscape(string $keyword) escape the string used in the like clause
 * @method static Schrosis\BladeSQL\BladeSQL\Contracts\Executor setConnection(\Illuminate\Database\ConnectionInterface|string|null $connectionName) set the connection
 *
 * @see \Schrosis\BladeSQL\BladeSQL\Contracts\Executor
 */
class BladeSQL extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Executor::class;
    }
}
