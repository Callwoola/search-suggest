<?php

namespace Callwoola\SearchSuggest\repository;

use Callwoola\SearchSuggest\Config\Configuration;
use Callwoola\SearchSuggest\lib\Translate\Pinyin;
use Predis\Client;


abstract class Cache{

	public function find($key){

    }

	public function store($key,$array=[])
    {
        $store  = storeRoom::instance();
    }

}

