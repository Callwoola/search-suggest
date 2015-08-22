<?php

namespace Callwoola\SearchSuggest\repository;

use Callwoola\SearchSuggest\Config\Configuration;
use Callwoola\SearchSuggest\lib\Translate\Pinyin;
use Predis\Client;
use storeRoom;


abstract class Bank{

	public function find($key){
        return
            storeRoom::instance()->find($key);
    }

	public function store($key,$array=[])
    {
        $store  = storeRoom::instance();
    }

}

