<?php
namespace Callwoola\SearchSuggest\Provider\Facades;

use Illuminate\Support\Facades\Facade;

class SearchSuggest extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'Callwoola\SearchSuggest\Provider\SearchSuggestProvider';
    }

}
