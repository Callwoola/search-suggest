<?php
namespace SuggestTest;

use Callwoola\SearchSuggest\Suggest;
use SuggestTest\Support\BaseTest;

class SearchTest extends BaseTest
{
    //public function testSearch()
    //{
    //    $suggest = new Suggest($this->connect);
    //
    //    $this->info('start search...');
    //
    //    $test = $suggest->search('纹理');
    //
    //    var_dump($test);
    //
    //    $this->assertTrue(true);
    //}


    /**
     * 简单搜索测试
     * @return void
     */
    public function testSearch()
    {
        $this->info("start search...");

        $suggest = new Suggest($this->connect);
        $words = [
            '进口',
            '中式',
            'zs',
            'zhong',
            'm',
            'ji',
            '窗框',
            'ck',
            'pvc',
            's',
            'EVO',
            'samsung',
        ];

        $specialTakeCare = [
            'iphone',
            'shou',
        ];

        $insertWords = [
            '软包',
            'boom',
        ];

        $words = array_merge($words, $specialTakeCare, $insertWords);

        foreach($words as $word)
        {
            $results = $suggest->search($word);

            $this->comment("\n\r".'result..'.$word );

            foreach($results as $result)
            {
                $this->info('   ' . $word . '=>' . serialize($result));
            }
        }

        $this->info("end search...");

        $this->assertTrue(true);
    }
}


