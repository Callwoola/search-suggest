<?php
namespace Callwoola\SearchSuggest\Provider;

use Illuminate\Support\ServiceProvider;

class SearchProvider extends ServiceProvider
{

    public function boot()
    {
        $this->package('Callwoola/searchsuggest', 'Callwoola/searchsuggest', __DIR__ . '/..');
    }

    public function register()
    {
        $this->app->bindShared('suggest', function ($app) {
            $redis = $app['redis']->connection();
            $path = 'Callwoola\\SearchSuggest\\Suggest';
            return new $path($redis, $app['config']['database.suggest']);
        });
    }
}
