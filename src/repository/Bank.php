<?php

namespace Callwoola\SearchSuggest\repository;


use Callwoola\SearchSuggest\StoreAdapter\StoreInterface;
use Callwoola\SearchSuggest\repository\C;

class Bank
{
    private $currency;


    public function  __construct(
        StoreInterface $store
    )
    {
//        $this->currency = $currency;
        $this->store = $store;
    }

    public function find($key)
    {
        return
            storeRoom::instance()->find($key);
    }

    public function storeCoin($key = '', $array = [])
    {
        $store = storeRoom::instance();
    }

    public function getCoin($name = '')
    {
        return '\\String Coin\\';
    }

    public function getStoreName(){
        return $this->store->getName();
    }
}

