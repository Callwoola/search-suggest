<?php
namespace Callwoola\Search\Provider\Facades;

use Illuminate\Support\Facades\Facade;

class SearchSuggest extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'SearchSuggest';
    }

}
