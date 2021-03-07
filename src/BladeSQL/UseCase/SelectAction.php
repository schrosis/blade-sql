<?php

namespace Schrosis\BladeSQL\BladeSQL\UseCase;

use Illuminate\Database\ConnectionInterface;
use Schrosis\BladeSQL\BladeSQL\Domain\Entity\Query;
use Schrosis\BladeSQL\BladeSQL\SelectResultCollection;

class SelectAction
{
    public function __invoke(
        ConnectionInterface $connection,
        Query $query
    ): SelectResultCollection {
        $result = $connection->select($query->getSQL(), $query->getParams());
        return new SelectResultCollection($result);
    }
}
