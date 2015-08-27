<?php

use Callwoola\SearchSuggest\lib\AnalyzeManage;
use Callwoola\SearchSuggest\lib\SearchCache;
use Callwoola\SearchSuggest\Container;
use Callwoola\SearchSuggest\repository\PinyinCurrency;
use Callwoola\SearchSuggest\repository\Bank;




class BankTest extends PHPUnit_Framework_TestCase
{

    public function testIndex()
    {
        $container = new Container;

        $container->bank(function(){
            return (new Bank(new PinyinCurrency))->getCoin();
        });
    }


}


