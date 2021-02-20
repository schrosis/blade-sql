<?php

namespace Schrosis\BladeSQL\BladeSQL\Domain\Entity;

use Schrosis\BladeSQL\BladeSQL\Domain\ValueObject\QuestionMarkPlaceholderParameters;
use Schrosis\BladeSQL\BladeSQL\Domain\ValueObject\QuestionMarkPlaceholderSQL;

class QuestionMarkPlaceholderQuery implements Query
{
    /**
     * question mark placeholder SQL
     *
     * @var QuestionMarkPlaceholderSQL
     */
    private $sql;

    /**
     * question mark placeholder SQL parameters
     *
     * @var QuestionMarkPlaceholderParameters
     */
    private $params;

    public function __construct(
        QuestionMarkPlaceholderSQL $sql,
        QuestionMarkPlaceholderParameters $params
    ) {
        $this->sql = $sql;
        $this->params = $params;
    }

    public function getQuestionMarkPlaceholderSQL(): QuestionMarkPlaceholderSQL
    {
        return $this->sql;
    }

    public function getSQL(): string
    {
        return $this->sql->getValue();
    }

    public function getQuestionMarkPlaceholderParameters(): QuestionMarkPlaceholderParameters
    {
        return $this->params;
    }

    public function getParams(): array
    {
        return $this->params->getValue();
    }
}
