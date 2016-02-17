<?php

namespace Callwoola\SearchSuggest\StoreAdapter;

use Predis\Client;

class RedisStore implements StoreInterface
{
    private $prefix = 'php-suggest-redis-prefix-';

    private $name;

    private $value = [];

    private $client;


    /**
     * @param $connect
     * 实例化 REDIS 为数据媒介
     */
    public function __construct($connect)
    {
        // TODO 优化性能

        $this->client = $connect;
    }

    /**
     * 储存单值以及 多值
     *
     * @param null $key
     * @param null $value
     * @return void
     */
    public function store($key = null, $value = null)
    {
        if ($this->client instanceof Client) {
            $key   = $key == null ? $this->name : $key;
            $value = $value == null ? $this->value : $value;
            if (is_array($value) AND count($value) > 0) {
                foreach ($value as $singleValue)
                {
                    $this->client->sadd($this->prefix . $key, $singleValue);
                }
            } elseif (is_string($value)) {
                $this->client->set($this->prefix . $key, $value);
            }


            return;
        }

        throw new CanNotStoreException();
    }

    public function get($name)
    {

    }

    /**
     * 全匹配数据 返回最合理的10个
     *
     * @param string $name
     * @return array
     */
    public function find($name)
    {
        $strategy = (strlen($name) > 1) ? $this->prefix . '*' . $name . '*' : $this->prefix . $name . '*';

        $keyList =  $this->client->keys($strategy);
        $returnList = [];

        foreach ($keyList as $keyString)
        {
            $returnList += [$keyString => $this->client->smembers($keyString)];
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
