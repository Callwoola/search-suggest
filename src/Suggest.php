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
    protected $bank;
    /**
     *
     */
    public function __construct()
    {
        $this->bank = new Bank();
    }

    /**
     * @param array $words
     * @return array
     */
    public function search($words = [])
    {
        // TODO 设置私有词库
        $bank = new Bank();
        $suggests = [];
        foreach($words as $word)
        {
            $results = $bank->withdrawal($word);
            foreach($results as $result){
                $suggests[] =  $result;
            }
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
        foreach ($sentences as $sentence) {
            $bank->deposit(new Coin($sentence));
        }
    }
}