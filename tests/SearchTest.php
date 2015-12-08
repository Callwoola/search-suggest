<?php
namespace SuggestTest;

use Callwoola\SearchSuggest\repository\Bank;
use Callwoola\SearchSuggest\StoreAdapter\RedisStore;
use SuggestTest\Support\BaseTest;
use Callwoola\SearchSuggest\Suggest;

class SearchTest extends BaseTest
{

    public $suggest;

    protected function setUp()
    {
        $this->suggest = new Suggest();
    }


    public function testListKey()
    {

        $this->info("\n\r........................list............................\n\r");
        $keyList = (new RedisStore())->getAll();
        foreach ($keyList as $keyString)
        {
            $this->info($keyString);
        }
        $this->info("\n\r........................end list............................\n\r");
    }

    /**
     * 简单搜索测试
     * @return void
     */
    public function testSearch()
    {
        $this->info("\n\r........................start search............................\n\r");

        $bank = new Bank();
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
            '进口',
            '进k',
            '进ko',
            '进kou',
            'j口',
            'ji口',
            'jin口',
            'j',
            'jk',
            'jik',
            'jink',
            'jink',
            'jinko',
            'jinkou',
        ];

        $insertWords = [
            '软包',
            'rb',
            'ru',
            'rua',
            'ruan',
            'ruanb',
            'ruanba',
            'ruanbao',
        ];

        $words = array_merge($words, $specialTakeCare, $insertWords);
        foreach($words as $word)
        {
            $results = $bank->withdrawal($word);
            $this->comment("\n\r".'result..'.$word );
            foreach($results as $result){
                $this->info('   '.$word . '=>' . $result);
            }
        }

        $this->assertTrue(true);

        $this->info("........................  end search............................\n\r");
    }
}


