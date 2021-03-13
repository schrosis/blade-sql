<?php

namespace Schrosis\BladeSQL\BladeSQL\Contracts;

use Schrosis\BladeSQL\BladeSQL\Domain\Entity\Query;
use Schrosis\BladeSQL\BladeSQL\SelectResultCollection;

interface Executor
{
    public function compile(string $blade, array $queryParams = []): Query;
    public function likeEscape(string $keyword): string;
    public function setConnection($connectionName): Executor;
    public function select(string $blade, array $queryParams = []): SelectResultCollection;
    public function update(string $blade, array $queryParams = []): int;
}
