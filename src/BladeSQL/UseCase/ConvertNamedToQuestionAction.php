<?php

namespace Schrosis\BladeSQL\BladeSQL\UseCase;

use RuntimeException;
use Schrosis\BladeSQL\BladeSQL\Domain\Entity\NamedPlaceholderQuery;
use Schrosis\BladeSQL\BladeSQL\Domain\Entity\QuestionMarkPlaceholderQuery;
use Schrosis\BladeSQL\BladeSQL\Domain\ValueObject\QuestionMarkPlaceholderParameters;
use Schrosis\BladeSQL\BladeSQL\Domain\ValueObject\QuestionMarkPlaceholderSQL;

class ConvertNamedToQuestionAction
{
    private const NAMED_PLACEHOLDER_REG = '/:(?<key>[a-zA-Z0-9_]+)/';
    private const QUESTION_MARK_PLACEHOLDER = '?';
    public function __invoke(NamedPlaceholderQuery $namedQuery): QuestionMarkPlaceholderQuery
    {
        $namedParams = $namedQuery->getParams();
        $questionParams = [];

        $questionSQL = preg_replace_callback(
            self::NAMED_PLACEHOLDER_REG,
            function ($matched) use ($namedParams, &$questionParams) {
                $key = $matched['key'];
                if (!isset($namedParams[$key])) {
                    throw new RuntimeException(sprintf('key [%s] does not exist in params', $key));
                }
                $questionParams[] = $namedParams[$key];
                return self::QUESTION_MARK_PLACEHOLDER;
            },
            $namedQuery->getSQL()
        );

        return new QuestionMarkPlaceholderQuery(
            new QuestionMarkPlaceholderSQL($questionSQL),
            new QuestionMarkPlaceholderParameters($questionParams)
        );
    }
}
