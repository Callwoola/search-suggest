<?php
namespace Callwoola\SearchSuggest\Provider;

use Illuminate\Support\ServiceProvider;

class SearchSuggestProvider extends ServiceProvider
{
//    private $commands = [
//        '\Callwoola\Search\Console\Commands\Update',
//    ];

//    public function boot()
//    {
//        $this->package('Callwoola/searchsuggest', 'Callwoola/searchsuggest', __DIR__ . '/..');
//    }

    /**
     * 搜索提示服务
    */
    public function register()
    {
        $this->app->bind('SearchSuggest', function () {
//            $path = 'Callwoola\\SearchSuggest\\SearchClient';
            return \Callwoola\SearchSuggest\SearchClient;
//            return new $path();
        });
        // remove useless code
//        $this->commands($this->commands);
    }
}