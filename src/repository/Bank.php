<?php

namespace Callwoola\SearchSuggest\repository;


class Bank
{
    private $currency;


    public function  __construct(CurrencyInterface $currency)
    {
        $this->currency = $currency;
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
        return 'Coin';
    }
}

