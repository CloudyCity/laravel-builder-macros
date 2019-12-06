<?php

namespace CloudyCity\LaravelBuilderMacros\Providers;

use CloudyCity\LaravelBuilderMacros\Library\Database\MySqlConnection;
use Illuminate\Database\Connection;
use Illuminate\Support\ServiceProvider;

class DatabaseServiceProvider extends ServiceProvider
{
    /**
     * Override the default connection for MySQL. This allows us to use `replace` etc.
     *
     * @link https://stidges.com/extending-the-connection-class-in-laravel
     * @link https://gist.github.com/VinceG/0fb570925748ab35bc53f2a798cb517c
     *
     * @return void
     */
    public function boot()
    {
        // 5.4 and above will use this method to bind
        if (method_exists(Connection::class, 'resolverFor')) {
            /* @noinspection PhpUndefinedMethodInspection */
            Connection::resolverFor('mysql', function ($connection, $database, $prefix, $config) {
                return new MySqlConnection($connection, $database, $prefix, $config);
            });
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // 5.3 and below will use this method to bind
        if (! method_exists(Connection::class, 'resolverFor')) {
            $this->app->bind('db.connection.mysql', MySqlConnection::class);
        }
    }
}
