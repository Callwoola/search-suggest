<?php

namespace Callwoola\SearchSuggest\StoreAdapter;

use Predis\Client;

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
     * @param null $key
     * @param null $value
     * @return void
     */
    public function store($key = null, $value = null)
    {
        if ($this->client instanceof Client)
        {
            $key   = $key == null ? $this->name : $key;
            $value = $value == null ? $this->value : $value;

            return $this->client->set(self::PREFIX . $key, serialize($value));
        }

        throw new CanNotStoreException();
    }

    /**
     * 全匹配数据 返回最合理的10个
     *
     * @param string $name
     * @return array
     */
    public function find($name)
    {
        $strategy = (strlen($name) > 1)
            ? self::PREFIX . '*' . $name . '*'
            : self::PREFIX . $name . '*';

        $keyList    = $this->client->keys($strategy);
        $returnList = [];

        foreach ($keyList as $keyString)
        {
            $returnList += [
                $keyString => $this->client->get($keyString)
            ];
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
