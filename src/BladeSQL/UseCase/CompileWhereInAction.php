<?php

namespace Schrosis\BladeSQL\BladeSQL\UseCase;

use RuntimeException;

class CompileWhereInAction
{
    public function __invoke($key, array $values): array
    {
        if (! is_string($key)) {
            throw new RuntimeException('Only string are allowed as array value keys');
        }

        if (! $this->isScalarArray($values)) {
            throw new RuntimeException('Only scalar array are allowed');
        }

        $convertedKeys = [];
        $count = count($values);
        for ($i = 0; $i < $count; ++$i) {
            $convertedKeys[] = 'bladesql_in_'.$key.'_'.$i;
        }

        return array_combine($convertedKeys, $values);
    }

    public function forNamedPlaceholder(string $key, array $values): array
    {
        return array_map(
            function ($el) {
                return ':'.$el;
            },
            array_keys($this->__invoke($key, $values))
        );
    }

    private function isScalarArray(array $array): bool
    {
        $notScalars = array_filter($array, function ($el) {
            return !is_scalar($el);
        });
        return count($notScalars) === 0;
    }
}
