<?php

use Callwoola\SearchSuggest\lib\AnalyzeManage;
use Callwoola\SearchSuggest\lib\SearchCache;
use Callwoola\SearchSuggest\Container;
use Callwoola\SearchSuggest\repository\PinyinCurrency;
use Callwoola\SearchSuggest\repository\Bank;
use Callwoola\SearchSuggest\StoreAdapter\StoreInterface;
use Callwoola\SearchSuggest\StoreAdapter\baseStore;


class BankTest extends PHPUnit_Framework_TestCase
{

    public function tes1tIndex()
    {
        $container = new Container;

        $container->bank(function () {
            return (new Bank(new PinyinCurrency))->getCoin();
        });

        // 测试拼音 的 储存


        // 拼音的读取


        // 更多的插件i


    }

    function getFile()
    {
        return [
            [new baseStore]
        ];
    }


    function testFile()
    {

        foreach($this->getFile() as $test){

        }
    }
}


