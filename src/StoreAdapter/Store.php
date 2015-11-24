<?php

namespace Callwoola\SearchSuggest\StoreAdapter;

class Store implements StoreInterface
{
    protected $store;

    /**
     * 根据默认 要求返回对象
     *
     * @param string $switch
     */
    public function __construct($switch = '')
    {
        if (isset($switch)) {
            $this->store = new RedisStore();
        } else {
            $this->store = new FileStore();
        }
    }

    /**
     * @param string $key
     * @param string $value
     * @return void
     */
    public function store($key, $value)
    {
        try {
            $this->store->store($key, $value);
        } catch (CanNotStoreException $exception) {
            $exception->getMessage();
        }
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function find($name)
    {
        $this->store->find($name);
    }

    /**
     * @param string $name
     * @return void
     */
    public function get($name)
    {
        $this->store->get($name);
    }

    /**
     * @param $name
     * @return void
     */
    public function key($name)
    {
        $this->store->key($name);
    }

    /**
     * @param $value
     * @return void
     */
    public function value($value)
    {
        $this->store->value($value);
    }

}
