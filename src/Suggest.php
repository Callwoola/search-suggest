<?php
namespace Callwoola\SearchSuggest;

use Exception;
use Callwoola\SearchSuggest\StoreAdapter\RedisStore;
use Callwoola\SearchSuggest\repository\Bank;
use Callwoola\SearchSuggest\repository\Coin;

/**
 * 搜索提示入口
 * @package Callwoola\SearchSuggest
 */
class Suggest
{
    const VERSION = '1.3.1';

    /**
     * @var Bank
     */
    protected $bank;

    /**
     * Suggest constructor.
     *
     * @param $connect
     */
    public function __construct($connect)
    {
        $connect->select(RedisStore::DATABASE);
        Pinyin::init();
        
        $this->bank = new Bank($connect);
    }

    /**
     * @param string $word
     * @return array
     */
    public function search($word)
    {
        $bank     = $this->bank;
        $suggests = [];
        $results  = $bank->withdrawal($word);

        foreach ($results as $result) {
            $suggests[] = $result;
        }

        return $suggests;
    }

    /**
     * push a coin in suggest bank
     *
     * @param $coin
     * @throws Exception
     * @return bool
     */
    public function push($coin = [])
    {
        if (!isset($coin['name']) OR !isset($coin['data'])) {
            throw new Exception('Data parse error');
        }

        $coin = Coin::parse($coin);
        $bank = $this->bank;

        return $bank->deposit($coin);
    }


    /**
     * 清空数据库
     *
     * @return mixed|void
     */
    public function clear()
    {
        return $this->bank->robAll();
    }
}
