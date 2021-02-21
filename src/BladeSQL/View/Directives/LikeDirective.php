<?php

namespace Schrosis\BladeSQL\BladeSQL\View\Directives;

use Schrosis\BladeSQL\BladeSQL\Domain\ValueObject\NamedPlaceholderParameters;
use Schrosis\BladeSQL\BladeSQL\UseCase\CompileWhereLikeAction;

class LikeDirective
{
    public const NAME = 'LIKE';
    private const PARSE_REG = '/^(?<forward>[%_]?)\{(?<key>[a-zA-Z0-9_]+)\}(?<backward>[%_]?)$/';

    /**
     * @var CompileWhereLikeAction
     */
    private static $compileWhereLikeAction;

    public static function process(string $expression): string
    {
        [$f, $key, $b] = self::parse($expression);
        return sprintf(
            "<?= %s::%s(%s, '%s', $%s, '%s', '%s') ?>\n",
            self::class,
            'compile',
            '$__bladesqlparams',
            $key,
            $key,
            $f,
            $b
        );
    }

    public static function compile(
        NamedPlaceholderParameters $params,
        string $key,
        string $value,
        string $forward,
        string $backward
    ): string {
        [$k, $v] = static::getCompileWhereLikeAction()
            ->__invoke($key, $value, $forward, $backward);

        $params->setValue($k, $v);
        return sprintf("LIKE :%s ESCAPE '\\'", $k);
    }

    private static function parse(string $expression): array
    {
        if (! preg_match(self::PARSE_REG, trim($expression), $matches)) {
            return ['', $expression, ''];
        }
        return [$matches['forward'], $matches['key'], $matches['backward']];
    }

    protected static function getCompileWhereLikeAction(): CompileWhereLikeAction
    {
        if (self::$compileWhereLikeAction === null) {
            self::$compileWhereLikeAction = app(CompileWhereLikeAction::class);
        }
        return self::$compileWhereLikeAction;
    }
}
