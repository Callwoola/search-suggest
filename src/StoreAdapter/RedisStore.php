<?php

namespace Callwoola\SearchSuggest\StoreAdapter;

use Predis\Client;

class RedisStore implements StoreInterface
{
    private $name = 'php-suggest-redis-prefix';

    private $value = [];

    private $client;

    public function __construct()
    {
        $config = ['scheme' => 'tcp', 'host' => '10.0.0.1', 'port' => 6379,];

        $this->client = new Client($config);
    }

    public function store($key = null, $value = null)
    {
        if ($this->client instanceof Client) {
            $key   = $key == null ? $this->name : $key;
            $value = $value == null ? $this->value : $value;
            $this->client->set($this->name . '-' . $key, $value);
        } else {
            throw new CanNotStoreException();
        }

    }

    public function get($name){

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