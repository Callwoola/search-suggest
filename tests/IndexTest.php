<?php

use Callwoola\Searchsuggest\lib\AnalyzeManage;
use Callwoola\Searchsuggest\lib\SearchCache;


class ssTest extends PHPUnit_Framework_TestCase
{
    protected $am;
    protected function setUp()
    {
        $this->am = new AnalyzeManage;
    }


    public function te1stIndex(){

        $AnalyzeManage = new AnalyzeManage();
        $AnalyzeManage->setDictArr([
            'lasticSearch(简称ES)由java语言实现,运行环境依赖java。ES 1.',
            '0/,查看页面信息,是否正常启动.status=200表示正常启动了，还有一些es的版本信息,name为配',
        ]);
        SearchCache::init()->ClearDatabase();
        $words = $AnalyzeManage->getCacheInitials();
        $words2 = $AnalyzeManage->getCachePinyin();
        $words3 = $AnalyzeManage->getCacheFuzzySoundPinyin();
        $testdata = $AnalyzeManage->mergeData($words, $words2, $words3);
        SearchCache::init()->setPinyinIndex($testdata);
        $searchResult=SearchCache::init()->searchPinyin('y');
        $keyResult = count($searchResult);
        $this->assertFalse(!$keyResult > 0);
    }


    /**
     * @covers AnalyzeManage::getCacheChinese
     */
    public function testChinese(){

        $this->am->setDictArr([
            'lasticSearch(简称ES)由java语言实现,运行环境依赖java。ES 1.',
            '0/,查看页面信息,是否正常启动.status=200表示正常启动了，还有一些es的版本信息,name为配',
        ]);

        SearchCache::init()->ClearDatabase();
        $theWord=$this->am->getCacheChinese();
        SearchCache::init()->setChineseIndex($theWord);
        $searchResult=SearchCache::init()->searchPinyin('运');
        $keyResult = count($searchResult);
        $this->assertFalse(!$keyResult > 0);
    }
}


