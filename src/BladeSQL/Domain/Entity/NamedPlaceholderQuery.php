<?php

namespace Schrosis\BladeSQL\BladeSQL\Domain\Entity;

use Schrosis\BladeSQL\BladeSQL\Domain\ValueObject\NamedPlaceholderSQL;
use Schrosis\BladeSQL\BladeSQL\Domain\ValueObject\NamedPlaceholderSQLParameters;

class NamedPlaceholderQuery implements Query
{
    /**
     * named placeholder SQL
     *
     * @var NamedPlaceholderSQL
     */
    private $sql;

    /**
     * named placeholder SQL parameters
     *
     * @var NamedPlaceholderSQLParameters
     */
    private $params;

    public function __construct(
        NamedPlaceholderSQL $sql,
        NamedPlaceholderSQLParameters $params
    ) {
        $this->sql = $sql;
        $this->params = $params;
    }

    public function getNamedPlaceholderSQL(): NamedPlaceholderSQL
    {
        return $this->sql;
    }

    public function getSQL(): string
    {
        return $this->sql->getValue();
    }

    public function getNamedPlaceholderSQLParameters(): NamedPlaceholderSQLParameters
    {
        return $this->params;
    }

    public function getParams(): array
    {
        return $this->params->getValue();
    }
}
