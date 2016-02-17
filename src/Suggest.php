<?php
namespace Callwoola\SearchSuggest;

use Callwoola\SearchSuggest\repository\Bank;
use Callwoola\SearchSuggest\repository\Coin;

/**
 * 搜索提示入口
 * @package Callwoola\SearchSuggest
 */
class Suggest
{
    const VERSION = '0.2.0';

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
        $this->bank = new Bank($connect);
    }

    /**
     * @param string $word
     * @return array
     */
    public function search($word)
    {
        // TODO 设置私有词库
        $bank = $this->bank;
        $suggests = [];
        $results = $bank->withdrawal($word);

        foreach($results as $result)
        {
            $suggests[] =  $result;
        }

        return $suggests;
    }

    /**
     * @param array $dict
     */
    public function createIndex($dict = [])
    {
        // TODO 创建索引
        $bank = new Bank();
        $sentences = $dict;

        foreach ($sentences as $sentence)
        {
            $bank->deposit(new Coin($sentence));
        }
    }
}
