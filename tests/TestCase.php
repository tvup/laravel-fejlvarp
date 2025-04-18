<?php

namespace Tvup\LaravelFejlvarp\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Testing\TestResponse;
use Orchestra\Testbench\TestCase as Orchestra;
use Symfony\Component\HttpFoundation\Response;
use Tvup\LaravelFejlvarp\LaravelFejlvarpServiceProvider;

abstract class TestCase extends Orchestra
{
    /**
     * @var TestResponse<Response>|null
     */
    public static ?TestResponse $latestResponse = null;

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Tvup\\LaravelFejlvarp\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelFejlvarpServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        config()->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
            'foreign_key_constraints' => true,
        ]);

        $migration = include __DIR__ . '/../database/migrations/create_incidents_table.php.stub';
        $migration->up();
    }
}
