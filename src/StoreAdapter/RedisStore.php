<?php

namespace Callwoola\SearchSuggest\StoreAdapter;

use Callwoola\SearchSuggest\repository\Cheque;
use Predis\Client;
use Callwoola\SearchSuggest\repository\Coin;

class RedisStore implements StoreInterface
{
    const PREFIX   = 'PHP-SUGGEST-REDIS-PREFIX-';
    const DATABASE = '15';

    private $name;

    private $value = [];

    private $client;

    /**
     * 实例化 REDIS 为数据媒介
     *
     * @param $connect
     */
    public function __construct($connect)
    {
        $this->client = $connect;
    }

    /**
     * 储存单值以及 多值
     *
     * @param Coin $coin
     * @return void
     */
    public function store(Coin $coin)
    {
        $value = $coin->getAccount();
        $key = $coin->getKey();

        if ($this->client instanceof Client)
        {
            $value = $value == null ? $this->value : $value;

            return $this->client->set($key, serialize($value));
        }

        throw new CanNotStoreException();
    }

    /**
     * 全匹配数据 返回最合理的10个
     *
     * @param Cheque $cheque
     * @return array
     */
    public function find(Cheque $cheque)
    {
        $strategies = $cheque->getSearchKey();

        $returnList = [];

        // 合并策略组
        foreach($strategies as $strategy)
        {
            $keyList = $this->client->keys($strategy);

            foreach ($keyList as $keyString)
            {
                $returnList += [
                    $keyString => $this->client->get($keyString)
                ];
            }
        }

        return $returnList;
    }

    public function setKey($name = '')
    {
        $this->name = $name;
    }

    public function setValue($array = [])
    {
        $this->value = $array;
    }

    public function clear()
    {
        return $this->client->flushdb();
    }

    public function getAll()
    {
        return $this->client->keys('*');
    }
}
