<?php


namespace Callwoola\SearchSuggest\repository;


/**
 *  Currency -> 单个词组管理工具
 *
 * Interface CurrencyInterface
 * @package Callwoola\SearchSuggest\repository
 */
interface CurrencyInterface{


    public function getTest();


    // 设置Key名称
    public function getKeyName();

    // 设置keyArray
    public function setkeyArray();


    // 设置匹配排名
    public function setNameArraySort();



    public function  StoreCurrency();
}