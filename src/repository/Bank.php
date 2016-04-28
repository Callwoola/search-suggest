<?php

namespace Callwoola\SearchSuggest\repository;

use Callwoola\SearchSuggest\StoreAdapter\Store;


/**
 * Class Bank
 * @package Callwoola\SearchSuggest\repository
 */
class Bank
{
    /**
     * @var Store
     */
    protected $store;


    /**
     * Bank constructor.
     * @param $connect
     */
    public function __construct($connect)
    {
        $this->store = new Store($connect);
    }

    /**
     * 存储一个内容
     *
     * @param Coin $coin
     */
    public function deposit(Coin $coin)
    {
        return $this->store->store(
            $coin->getCharName() . '@' . $coin->getClearName(),
            $coin->getAccount()
        );
    }


    /**
     * 查找匹配内容
     *
     * @param $word
     * @return array
     */
    public function withdrawal($word)
    {
        $parseWord = Analyze::parse($word);

        $accounts = $this->store->find($parseWord);

        $words = Analyze::sort($word, $accounts);

        return $words;
    }


    /**
     * 清空数据库
     *
     * @return mixed|void
     */
    public function robAll()
    {
        return $this->store->clear();
    }
}

