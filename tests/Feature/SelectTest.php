<?php

namespace Schrosis\BladeSQL\Tests\Feature;

use PDO;
use Schrosis\BladeSQL\Facades\BladeSQL;
use Schrosis\BladeSQL\Providers\BladeSQLServiceProvider;
use Schrosis\BladeSQL\Tests\TestCase;

class SelectTest extends TestCase
{
    private $database;

    private $testData = [
        ['1', 'examplename', 'example@example.com', 'hashed_password', '2021-02-22 10:00:00', '2021-02-22 10:00:00'],
        ['2', 'samplename', 'sample@example.com', 'hashed_password', '2021-02-22 10:00:00', '2021-02-22 10:00:00'],
        ['3', 'testname', 'test@example.com', 'hashed_password', '2021-02-22 10:00:00', '2021-02-22 10:00:00'],
    ];

    public function testSelect()
    {
        $result = BladeSQL::select('test-select');
        $expected = array_map(
            function ($r) {
                return (object)array_combine(['id', 'name', 'email', 'password', 'created_at', 'updated_at'], $r);
            },
            $this->testData
        );

        $this->assertEquals($expected, $result->toArray());


        $result = BladeSQL::select('test-select', ['email' => 'example@example.com']);
        $this->assertEquals(
            array_values(array_filter($expected, function ($r) {
                return $r->email === 'example@example.com';
            })),
            $result->toArray()
        );

        $result = BladeSQL::select('test-select', ['name' => 'exa']);
        $this->assertEquals(
            array_values(array_filter($expected, function ($r) {
                return strpos($r->name, 'exa') === 0;
            })),
            $result->toArray()
        );

        $result = BladeSQL::select('test-select', ['name' => ['examplename', 'testname']]);
        $this->assertEquals(
            array_values(array_filter($expected, function ($r) {
                return in_array($r->name, ['examplename', 'testname'], true);
            })),
            $result->toArray()
        );
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
        $stmt = $pdo->prepare('INSERT INTO users VALUES(?, ?, ?, ?, ?, ?)');
        foreach ($this->testData as $parameters) {
            $stmt->execute($parameters);
        }
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
