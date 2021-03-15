# blade-sql
[![License](https://poser.pugx.org/schrosis/blade-sql/license)](//packagist.org/packages/schrosis/blade-sql)
[![Latest Stable Version](https://poser.pugx.org/schrosis/blade-sql/v)](//packagist.org/packages/schrosis/blade-sql)
[![Latest Unstable Version](https://poser.pugx.org/schrosis/blade-sql/v/unstable)](//packagist.org/packages/schrosis/blade-sql)
[![blade-sql-test](https://github.com/schrosis/blade-sql/actions/workflows/blade-sql.yml/badge.svg)](https://github.com/schrosis/blade-sql/actions/workflows/blade-sql.yml)

- - -

## Introduction

blade-sql provides the generation and execution of SQL using Blade, Laravel's template engine

When you want to write a complex SQL with more than 100 rows, isn't it hard to write it in the query builder?  
Sometimes you want to write raw SQL for tuning purposes  
In such cases, blade-sql is useful!

## Requirements

 - PHP(^7.3|^8.0)
 - PDO
 - Laravel:(^6.0|^7.0|^8.0)

## Installation

```
composer require schrosis/blade-sql
```

Laravel uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider


If you don't use auto-discovery, add the `BladeSQLServiceProvider` to the providers array in `config/app.php`  
And if you use facade aliases, add `BladeSQL` to the aliases array

```php
Schrosis\BladeSQL\Providers\BladeSQLServiceProvider::class,
```

```php
'BladeSQL' => Schrosis\BladeSQL\Facades\BladeSQL::class,
```

### Copy the package config to your local config with the publish command

```
php artisan vendor:publish --provider="Schrosis\BladeSQL\Providers\BladeSQLServiceProvider"
```

## Usage

Create `.blade.php` file for blade-sql in `resources/sql/` dir

```blade
{{-- For example, resources/sql/users/select.blade.php --}}
SELECT id, name FROM users WHERE id = :id
```

## Execute SELECT Query
Execute a query using the `BladeSQL` facade

```php
use Schrosis\BladeSQL\Facades\BladeSQL;

$user = BladeSQL::select('users.select', ['id' => 1])->first();
// (object)[
//     'id' => '1',
//     'name' => 'examplename'
// ]
```

The result of a select query is a `Collection` object of `stdClass`

You can also turn it into a `Collection` object of `Models` or your `Entity`

```php
use Schrosis\BladeSQL\Facades\BladeSQL;
use App\Moldes\Todo;
use App\Entities\YourTodoEntity;

$stdClassCollection = BladeSQL::select('todos.select');

// to model collection
$modelCollection = $stdClassCollection
    ->model(Todo::class); // or model(new Todo())

// to entity collection
$entityCollection = $stdClassCollection
    ->entity(YourTodoEntity::class);
```

The `entity` method argument expects a class with a method named `fromArray`  
Otherwise, you can use the `Collection::map()`

```php
class YourTodoEntity
{
    private $id;
    private $contents;
    private $finished_at;
    private $created_at;

    public static fromArray(array $data)
    {
        // some code
    }
}
```

### Execute INSERT UPDATE DELETE Query

You can also use the `BladeSQL` facade to perform an `insert` `update` `delete` query  

The way to call these methods is the same as the `select`  
The difference is that these methods return the number of rows that have been updated

```php
$insertedRowNum = BladeSQL::insert('todos.new', [
    'contents' => 'Implement that function',
]);

$updatedRowNum = BladeSQL::update('todos.done', [
    'id' => 1,
    'finished_at' => \Carbon\Carbon::now(),
]);

$deletedRowNum = BladeSQL::delete('todos.delete', [
    'id' => 1,
]);
```

### Run on a specific connection

If you want to use a connection other than the default one, call the `setConnection` method

```php
// Same string value as the argument of DB::connection()
BladeSQL::setConnection('mysql::write')->update('users.change-password', $queryParams);
// or
// Accept ConnectionInterface
$connection = DB::connection('mysql::write');
BladeSQL::setConnection($connection)->update('users.change-password', $queryParams);
```

Also use it when doing a transaction
## Blade Directives and Components

In addition to the basic features of blade, provides directives and components similar to Java's `mybatis`

### @where

Erase the leading `AND` or `OR` and prefix it with `WHERE`

`@where` component is useful when using `@if` to create WHERE clauses

```blade
@where
AND col_1 = 'value'
AND col_2 = 'value'
@endwhere
```

It will compile like this

```
WHERE col_1 = 'value'
AND col_2 = 'value'
```

If the `$slot` of `@where` is empty, the first `WHERE` is not attached

### @set

Works just like `@where`  
Remove the `,` at the end and prefix it with `SET`

`@set` component is useful when using `@if` to create a `SET` clause for an update query.

```blade
@set
col_1 = 'value',
col_2 = 'value',
@endset
```

It will compile like this

```
SET col_1 = 'value',
col_2 = 'value'
```

### @IN

`@IN` directive Create an `IN` clause from an array

```blade
@IN(id_list)
```

If `$id_list` is `[1, 2, 3]`, it will be compiled like this

```
IN(?, ?, ?)
```

### @LIKE

`@LIKE` directive escapes values that are bound to the `LIKE` clause

```blade
@LIKE(name)
```

If `$name` is `'strawberry 100%'`, then it will compile like this

```
LIKE ? ESCAPE '\'
```

And `'strawberry 100%'` will be escaped to `'strawberry 100\%'`

You can also easily add `_` and `%`

```blade
{{-- if $name is 'strawberry 100%' --}}
@LIKE({name}%) {{-- 'strawberry 100\%%' --}}
@LIKE(_{name}) {{-- '_strawberry 100\%' --}}
@LIKE(%{name}%) {{-- '%strawberry 100\%%' --}}
```
