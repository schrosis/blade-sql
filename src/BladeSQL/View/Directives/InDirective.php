<?php

namespace Schrosis\BladeSQL\BladeSQL\View\Directives;

use RuntimeException;
use Schrosis\BladeSQL\BladeSQL\Domain\ValueObject\NamedPlaceholderParameters;
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
        return sprintf(
            "<?= %s::%s(%s, '%s', $%s) ?>\n",
            self::class,
            'compile',
            '$__bladesqlparams',
            $key,
            $key
        );
    }

    public static function compile(NamedPlaceholderParameters $params, string $key, array $values): string
    {
        if (count($values) === 0) {
            throw new RuntimeException(
                'The number of elements in the in clause is zero. Enclose it in an if directive'
            );
        }
        $compileWhereInAction = static::getCompileWhereInAction();

        foreach ($compileWhereInAction($key, $values) as $k => $v) {
            $params->setValue($k, $v);
        }

        $keys = $compileWhereInAction->forNamedPlaceholder($key, $values);
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
