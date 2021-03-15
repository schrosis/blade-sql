<?php

namespace Schrosis\BladeSQL\Tests\Unit;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use Schrosis\BladeSQL\BladeSQL\SelectResultCollection;
use Schrosis\BladeSQL\Tests\TestCase;

class ExampleEntity
{
    public static function fromArray(array $data)
    {
        return new self;
    }
}

class NotEntity {}

class ExampleModel extends Model {}

class NotModel {}

class SelectResultCollectionTest extends TestCase
{
    public function testParentClass()
    {
        $selectResult = new SelectResultCollection();
        $this->assertInstanceOf(Collection::class, $selectResult);
    }

    public function testEntity()
    {
        $selectResult = new SelectResultCollection([[
            'id' => 1,
            'name' => 'sample data',
        ]]);
        $entities = $selectResult->entity(ExampleEntity::class);

        $this->assertInstanceOf(Collection::class, $entities);
        $this->assertNotInstanceOf(SelectResultCollection::class, $entities);

        foreach ($entities->all() as $entity) {
            $this->assertInstanceOf(ExampleEntity::class, $entity);
        }
    }

    public function testThrowExceptionWhenNotEntityClass()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The argument entityClass must have a fromArray method');

        $selectResult = new SelectResultCollection([[
            'id' => 1,
            'name' => 'sample data',
        ]]);
        $selectResult->entity(NotEntity::class);
    }

    public function testModel()
    {
        $selectResult = new SelectResultCollection([[
            'id' => 1,
            'name' => 'sample data',
        ]]);
        $models = $selectResult->model(ExampleModel::class);

        $this->assertInstanceOf(Collection::class, $models);
        $this->assertNotInstanceOf(SelectResultCollection::class, $models);

        foreach ($models->all() as $model) {
            $this->assertInstanceOf(ExampleModel::class, $model);
        }
    }

    public function testThrowExceptionWhenNotModelClass()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('If the argument model is a string, it must have a fromArray method');

        $selectResult = new SelectResultCollection([[
            'id' => 1,
            'name' => 'sample data',
        ]]);
        $selectResult->model(NotModel::class);
    }

    public function testThrowExceptionWhenNotClass()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('If the argument model is a string, it must have a fromArray method');

        $selectResult = new SelectResultCollection([[
            'id' => 1,
            'name' => 'sample data',
        ]]);
        $selectResult->model('something string');
    }

    public function testThrowExceptionWhenNotModelInstace()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Must be a fully qualified class name or instance of Model');

        $selectResult = new SelectResultCollection([[
            'id' => 1,
            'name' => 'sample data',
        ]]);
        $selectResult->model((object)['invalid arg']);
    }
}
