<?php

namespace Callwoola\SearchSuggest\repository;


abstract class Bank{

	public function find($key){
        return
            storeRoom::instance()->find($key);
    }

	public function storeCoin($key,$array=[])
    {
        $store  = storeRoom::instance();
    }

    public function getCoin($name ){

    }
}

