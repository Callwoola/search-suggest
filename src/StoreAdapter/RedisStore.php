<?php

namespace Callwoola\SearchSuggest\StoreAdapter;

use Predis\Client;

class RedisStore implements StoreInterface
{
    private $name = 'php-suggest-redis-prefix';

    private $value = [];

    private $client;


    /**
     * 实例化 REDIS 为数据媒介
     */
    public function __construct()
    {
        // TODO 优化性能

        $config = ['scheme' => 'tcp', 'host' => '127.0.0.1', 'port' => 6379,];

        $this->client = new Client($config);
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
                foreach ($value as $singleValue) {
                    $this->client->sadd($this->name . '-' . $key, $singleValue);
                }
            } elseif (is_string($value)) {
                $this->client->set($this->name . '-' . $key, $value);
            }

            return;
        }

        throw new CanNotStoreException();
    }

    public function get($name)
    {

    }

    public function find($name)
    {
        $this->get($this->name . "*");
    }

    public function key($name = '')
    {
        $this->name = $name;
    }

    public function value($array = [])
    {
        $this->value = $array;
    }


}