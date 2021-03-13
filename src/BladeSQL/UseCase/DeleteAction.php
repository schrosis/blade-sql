<?php

namespace Schrosis\BladeSQL\BladeSQL\UseCase;

use Illuminate\Database\ConnectionInterface;
use Schrosis\BladeSQL\BladeSQL\Domain\Entity\Query;

class DeleteAction
{
    public function __invoke(ConnectionInterface $connection, Query $query): int
    {
        return $connection->delete($query->getSQL(), $query->getParams());
    }
}
