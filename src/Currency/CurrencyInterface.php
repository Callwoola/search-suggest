<?php


namespace Callwoola\SearchSuggest\Currency;


/**
 *  Currency -> 单个词组管理工具
 *
 * Interface CurrencyInterface
 * @package Callwoola\SearchSuggest\repository
 */
interface CurrencyInterface
{

    /**
     * 设置Key名称
     *
     * @param string $key
     * @return mixed
     */
    public function getCurrency($key = '');

    // 设置keyArray
    /**
     * @param $array
     * @return mixed
     */
    public function setkeyArray($array);

    /**
     * 设置匹配排名
     *
     * @param Sort $sort
     * @return mixed
     */
    public function setNameArraySort(Sort $sort);


    /**
     * 储存 Currency
     *
     * @return mixed
     */
    public function  StoreCurrency();
}