<?php
namespace Callwoola\Search\Provider\Facades;

use Illuminate\Support\Facades\Facade;

class Suggest extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'suggest';
    }

}
