<?php

namespace Schrosis\BladeSQL\BladeSQL;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

class SelectResultCollection extends Collection
{
    public function entity(string $entityClass): Collection
    {
        if (! $this->hasFromArrayMethod($entityClass)) {
            throw new InvalidArgumentException(
                'The argument entityClass must have a fromArray method'
            );
        }

        return $this
            ->toBase()
            ->map(function ($item) use ($entityClass) {
                return [$entityClass, 'fromArray']((array)$item);
            });
    }

    private function hasFromArrayMethod(string $class): bool
    {
        try {
            $refMethod = new ReflectionMethod($class, 'fromArray');
            return $refMethod->isPublic() && $refMethod->isStatic();
        } catch (ReflectionException $e) {}

        return false;
    }

    /**
     * map to model
     *
     * @param string|Model $modelClass
     * @return Collection
     */
    public function model($model): Collection
    {
        if (is_string($model)) {
            if (! $this->isModelClass($model)) {
                throw new InvalidArgumentException(
                    'If the argument model is a string, it must have a fromArray method'
                );
            }
            $model = new $model;
        }

        return $this
            ->toBase()
            ->map(function($item) use ($model) {
                return $model->newFromBuilder($item);
            });
    }

    private function isModelClass(string $modelClass): bool
    {
        try {
            $refClass = new ReflectionClass($modelClass);
            return $refClass->isSubclassOf(Model::class);
        } catch (ReflectionException $e) {}

        return false;
    }
}
