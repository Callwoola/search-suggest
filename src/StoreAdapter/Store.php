<?php

namespace Callwoola\SearchSuggest\StoreAdapter;

use Callwoola\SearchSuggest\repository\Cheque;
use Callwoola\SearchSuggest\repository\Coin;
use Callwoola\SearchSuggest\repository\Account;

class Store implements StoreInterface
{
    protected $store;

    /**
     * 根据默认 要求返回对象
     *
     * @param string $connect
     */
    public function __construct($connect = null)
    {
        if (isset($connect)) {
            $this->store = new RedisStore($connect);
        } else {
            $this->store = new FileStore();
        }
    }

    /**
     * @param string $key
     * @return void
     */
    public function store(Coin $coin)
    {
        try {
            $this->store->store($coin);
        } catch (CanNotStoreException $exception) {
            $exception->getMessage();
        }
    }

    /**
     * 查找数据
     *
     * @param Cheque $cheque
     * @return mixed
     */
    public function find(Cheque $cheque)
    {
        $result = $this->store->find($cheque);

        return Account::generate($result);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function get($name)
    {
        return $this->store->get($name);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function setKey($name)
    {
        $this->store->key($name);
    }

    /**
     * @param $value
     * @return void
     */
    public function setValue($value)
    {
        $this->store->value($value);
    }

    public function clear()
    {
        $this->store->clear();
    }

}
