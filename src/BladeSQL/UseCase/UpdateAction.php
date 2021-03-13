<?php

namespace Schrosis\BladeSQL\BladeSQL\UseCase;

use Illuminate\Database\ConnectionInterface;
use Schrosis\BladeSQL\BladeSQL\Domain\Entity\Query;

class UpdateAction
{
    public function __invoke(ConnectionInterface $connection, Query $query): int
    {
        return $connection->update($query->getSQL(), $query->getParams());
    }
}
