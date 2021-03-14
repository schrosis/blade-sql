<?php

namespace Schrosis\BladeSQL\Tests\Feature;

use Illuminate\Support\Facades\DB;
use PDO;
use Schrosis\BladeSQL\Facades\BladeSQL;
use Schrosis\BladeSQL\Providers\BladeSQLServiceProvider;
use Schrosis\BladeSQL\Tests\TestCase;

class InsertTest extends TestCase
{
    private $database;

    public function testInsert()
    {
        $insertData = [
            'name' => 'updated name',
            'email' => 'example@example.com',
            'password' => 'hashed_password',
        ];
        $result = BladeSQL::insert('test-insert', $insertData);
        $this->assertSame(1, $result);

        $inserted = DB::select('SELECT * FROM users WHERE id = 1');
        $this->assertSame($insertData['name'], $inserted[0]->name);
        $this->assertSame($insertData['email'], $inserted[0]->email);
        $this->assertSame($insertData['password'], $inserted[0]->password);
    }

    protected function getEnvironmentSetUp($app): void
    {
        $this->database = tempnam(storage_path(''), 'sqlite_');
        $app['config']->set('database.default', 'test');
        $app['config']->set('database.connections.test', [
            'driver' => 'sqlite',
            'database' => $this->database,
        ]);

        $this->loadStubSQL($app, false);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $pdo = new PDO('sqlite:'.$this->database, null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
        $pdo->exec('DROP TABLE IF EXISTS users');
        $pdo->exec('CREATE TABLE users(
            id INTEGER PRIMARY KEY,
            name TEXT NOT NULL,
            email TEXT NOT NULL,
            password TEXT NOT NULL,
            created_at DATETIME,
            updated_at DATETIME
        )');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        @unlink($this->database);
    }

    protected function getPackageProviders($app)
    {
        return [BladeSQLServiceProvider::class];
    }
}
