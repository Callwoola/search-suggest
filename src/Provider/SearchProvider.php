<?php
namespace Callwoola\Search\Provider;

use Illuminate\Support\ServiceProvider;

class SearchProvider extends ServiceProvider
{
    private $commands = [
        '\Callwoola\Search\Console\Commands\Update',
    ];

    public function boot()
    {
        $this->package('Callwoola/searchsuggest', 'Callwoola/searchsuggest', __DIR__ . '/..');
    }

    public function register()
    {
        $this->app->bindShared('search', function ($app) {
            $path = 'Callwoola\\SearchSuggest\\SearchClient';
            //$config = $app['config']->get('Callwoola/search::config');
            return new $path();
        });
        $this->commands($this->commands);
    }
}