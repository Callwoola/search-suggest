<?php

namespace Callwoola\SearchSuggest\repository;


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

