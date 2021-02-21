<?php

namespace Schrosis\BladeSQL\BladeSQL\UseCase;

use RuntimeException;

class CompileWhereLikeAction
{
    private const LIKE_ANY = 0b01;
    private const LIKE_ANYONE = 0b10;

    private $likeEscapeAction;

    public function __construct(LikeEscapeAction $likeEscapeAction)
    {
        $this->likeEscapeAction = $likeEscapeAction;
    }

    public function __invoke(
        string $key,
        string $value,
        string $forward,
        string $backward
    ): array {
        return [
            sprintf(
                'bladesql_like_%s_%d%d',
                $key,
                $this->convertMarkToInt($forward),
                $this->convertMarkToInt($backward)
            ),
            $forward.$this->likeEscapeAction->__invoke($value).$backward
        ];
    }

    private function convertMarkToInt(string $mark): int
    {
        switch ($mark) {
            case '%':
                return self::LIKE_ANY;
            case '_':
                return self::LIKE_ANYONE;
            case '':
                return 0;
            default:
                throw new RuntimeException('invalid character. allowed % or _');
        }
    }
}
