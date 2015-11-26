<?php

namespace Callwoola\SearchSuggest\repository;


use Callwoola\SearchSuggest\StoreAdapter\Store;
use Callwoola\SearchSuggest\StoreAdapter\StoreInterface;


class Bank
{
    private $currency;

    protected $store;


    public function  __construct(
//        StoreInterface $store
    )
    {
//        $this->store = $store;
        $this->store = new Store();
    }

    public function find($key)
    {
//        return storeRoom::instance()->find($key);
    }

    public function storeCoin($key = '', $array = [])
    {
//        $store = storeRoom::instance();
    }

    public function getCoin($name = '')
    {
        return '\\String Coin\\';
    }

    public function getStoreName(){
//        return $this->store->getName();
    }

    public function deposit(CoinInterface $coin)
    {
        echo "store ing.. \n";

        $this->store->store($coin->getName(),$coin->getValue());
    }
}

