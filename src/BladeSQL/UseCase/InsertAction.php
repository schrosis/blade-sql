<?php

namespace Schrosis\BladeSQL\BladeSQL\UseCase;

use Illuminate\Database\ConnectionInterface;
use Schrosis\BladeSQL\BladeSQL\Domain\Entity\Query;

class InsertAction
{
    public function __invoke(ConnectionInterface $connection, Query $query): int
    {
        return $connection->insert($query->getSQL(), $query->getParams());
    }
}
