<?php

namespace Callwoola\SearchSuggest\repository;

use Callwoola\SearchSuggest\Currency\Sort;
use Callwoola\SearchSuggest\Pinyin;
use Callwoola\SearchSuggest\StoreAdapter\RedisStore;
use phpSplit\Split\Split;


/**
 * Class Analyze
 * @package Callwoola\SearchSuggest\repository
 */
class Analyze
{
    protected $string;

    protected $account;

    /**
     * ...
     *
     * @param $strings
     * @return array
     */
    public static function generate($strings)
    {
        // TODO 逐个连接字符

        $generates = [];
        foreach ($strings as $string)
        {
            // 添加
            $name = Pinyin::getPinyin($string) . '@' . Pinyin::getPinyinFirst($string);
            $info = [];

            $account = new Account();
            $account->setName($name);
            $account->addAmount($string, $info);
            $generates[] = $account;
        }

        return $generates;
    }

    /**
     * 经典排序法
     *
     * @param $origin
     * @param array $accounts
     * @return array
     */
    public static function sort($origin, array $accounts)
    {
        $sorter  = new Sort($origin, $accounts);
        $results = $sorter->all();

        return self::revertData($results,$accounts);
    }

    /**
     * @param $keies
     * @param array $accounts
     * @return array
     */
    public static function revertData($keies, array $accounts)
    {
        $result = [];

        foreach ($accounts as $account)
            foreach ($keies as $key)
                if ($account->getName() == RedisStore::PREFIX . $key)
                    $result[] = $account->getInventory();

        return $result;
    }

    /**
     * 返回干净的字符串
     *
     * @param string $name
     * @return string;
     */
    public static function clear($name)
    {
        return strtolower(
            preg_replace('/[[:punct:]]/u', '', $name)
        );
    }
}