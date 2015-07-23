<?php

use Callwoola\Search\lib\SearchCache;
use Callwoola\Search\lib\Indexdata\AnalyzeManage;

class CacheTest extends PHPUnit_Framework_TestCase
{


    /**
     * 测试拼音缓存返回结果
     */
    public function testPinyinSearchByCache()
    {

        $list = SearchCache::init()->search("a*");
        $this->assertFalse(!(count($list) > 0 and count($list) < 9), "return list error");
        $list = SearchCache::init()->search("sui*", 1);
        $this->assertFalse(!(count($list) > 0 and count($list) < 9), "return list error");
    }

    /**
     * 词语装换 拼音 句子
     */
    public function testPinyinFuzzySound()
    {
        $AnalyzeManage=new AnalyzeManage();
        $list=$AnalyzeManage->CacheFuzzySoundPinyin();
        $this->assertFalse(!(count($list) > 0), "return list error");
    }


    /**
     * 词语装换 拼音 句子
     */
    public function testGetNum()
    {
        $this->assertTrue(SearchCache::init()->getCountNum('沙发') > 0);
        $this->assertTrue(SearchCache::init()->getCountNum('茶几') > 0);
        $this->assertTrue(SearchCache::init()->getCountNum('红色') > 0);

    }

}