<?php
namespace SuggestTest;

use Callwoola\SearchSuggest\Suggest;
use SuggestTest\Support\BaseTest;

class SearchTest extends BaseTest
{
    /**
     * 简单搜索测试
     *
     * @return void
     */
    public function test_search()
    {
        $this->info("start search...");

        $suggest = new Suggest($this->connect);
        $this->error('init test time:');
        $this->error(microtime() - $this->baseStartTime);

        $words = [
            'zhong',
            'm',
            'ji',
            'pvc',
            's',
            'iphone',
            's',
        ];

        $specialTakeCare = [
            '美生',
            '美生雅素丽',
            '美生·雅素丽',
        ];

        $insertWords = [
            'ruanbao',
            '钰尚.如易',
            '深',
            'shenz',
            '天下',
        ];

        $words = array_merge($words, $specialTakeCare, $insertWords);

        foreach($words as $word)
        {
            $start = microtime();

            $results = $suggest->search($word, self::TYPE_ONE);

            $this->error(microtime() - $start);

            $this->comment("\n\r".'result..'.$word );

            foreach($results as $result)
            {
                $this->info('   ' . $word . '=>' . $result['raw_name']);
            }
        }

        $this->info("end search...");

        $this->assertTrue(true);
    }

    public function test_only_chinese()
    {
        $suggest = new Suggest($this->connect, [
            'cn_inlcude_pinyin' => false
        ]);

        $results = $suggest->search("大理", self::TYPE_ONE);
        var_dump($results);

        $this->assertTrue(true);
    }

    public function test_choose_redis()
    {
        $this->info('-- test choose detabase --');
        $suggest = new Suggest($this->connect, [
            'database' => 13
        ]);

        $results = $suggest->search("大理", self::TYPE_ONE);
        var_dump($results);

        $this->assertTrue(true);
    }
}


