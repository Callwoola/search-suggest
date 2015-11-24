<?php


namespace Callwoola\SearchSuggest\Currency;


class PinyinCurrency implements CurrencyInterface
{


    private $key = '';

    private $array = [];

    public function  __construct()
    {

    }


    // 设置Key名称
    public function getCurrency($key = '')
    {

    }

    // 设置keyArray
    public function setkeyArray($array = [])
    {

    }


    // 设置匹配排名
    public function setNameArraySort(Sort $sort)
    {
        return null;
    }


    public function  StoreCurrency()
    {

    }
}