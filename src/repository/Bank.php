<?php

namespace Callwoola\SearchSuggest\repository;


use Callwoola\SearchSuggest\StoreAdapter\Store;


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
    }

    public function getStoreName()
    {
//        return $this->store->getName();
    }

    public function deposit(Coin $coin)
    {
        $accounts = Analyze::start($coin->getSentence());

        foreach($accounts as $account)
        {
            $this->store->store($account->getName(),$account->getAmount());
        }
    }

    public function withdrawal($word)
    {
        $word = Analyze::parse($word);

        return $this->store->find($word);
    }

    public function robAll()
    {
        return $this->store->clear();
    }
}

