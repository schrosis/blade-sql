<?php

namespace Schrosis\BladeSQL\BladeSQL\View;

use RuntimeException;
use Schrosis\BladeSQL\BladeSQL\UseCase\CompileWhereInAction;

class InDirective
{
    public const NAME = 'IN';

    /**
     * @var CompileWhereInAction
     */
    private static $compileWhereInAction;

    public static function process(string $key): string
    {
        return sprintf("<?= %s::%s('%s', $%s) ?>", self::class, 'compile', $key, $key);
    }

    public static function compile(string $key, array $values): string
    {
        if (count($values) === 0) {
            throw new RuntimeException(
                'The number of elements in the in clause is zero. Enclose it in an if directive'
            );
        }
        $keys = static::getCompileWhereInAction()
            ->forNamedPlaceholder($key, $values);
        return count($values) === 1
            ? sprintf('= %s', $keys[0])
            : sprintf('IN(%s)', implode(', ', $keys));
    }

    protected static function getCompileWhereInAction(): CompileWhereInAction
    {
        if (self::$compileWhereInAction === null) {
            self::$compileWhereInAction = app(CompileWhereInAction::class);
        }
        return self::$compileWhereInAction;
    }
}
