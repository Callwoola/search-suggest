<?php
use Callwoola\Search\lib\Indexdata\AnalyzeUrl;
use Callwoola\Search\lib\Indexdata\AnalyzeManage;
use Callwoola\Search\lib\SearchCache;

class AnalyzePinyinTest extends PHPUnit_Framework_TestCase
{

    public function testCacheChinese()
    {
        $AnalyzeManage = new AnalyzeManage();
        $this->assertTrue($AnalyzeManage->getCacheChinese());
    }

    /**
     * 分析测试
     */
    public function testAnalyze()
    {
        $AnalyzeManage = new AnalyzeManage();
        $words = $AnalyzeManage->getAnalyze("红色沙发和衣柜");
        $expectWords = ["红色", "沙发", "和", "衣柜"];
        $this->assertEquals($expectWords, $words, "words no Equals");
    }


    public function testCacheAnalyze()
    {
        $AnalyzeManage = new AnalyzeManage();
        $words = $AnalyzeManage->CacheInitials();
        $words2 = $AnalyzeManage->CachePinyin();
        $words3 = $AnalyzeManage->CacheFuzzySoundPinyin();
        $testdata = $AnalyzeManage->mergeData($words, $words2, $words3);
        SearchCache::init()->setIndex($testdata);
        $keyResult = count(SearchCache::init()->getClient()->keys('Callwoolasearch*'));
        $this->assertFalse(!$keyResult > 0);
    }
}