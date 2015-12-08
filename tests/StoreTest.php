<?php
namespace SuggestTest;

use phpSplit\Split\Split;
use Callwoola\SearchSuggest\Pinyin;
use Callwoola\SearchSuggest\repository\Bank;
use Callwoola\SearchSuggest\repository\Coin;
use SuggestTest\Data\TestData;

/**
 * Class BankTest
 * @package SuggestTest
 */
class BankTest extends BaseTest
{
    use TestData;

    protected function setUp()
    {

    }

    /**
     * @return null
     */
    public function testSplit()
    {
        $this->info('start php-split testing ...');
        $split = new Split();
        $split = $split->start("苹果手机iphone6");
        foreach ($split as $word) {
            $this->info($word);
        }
        $this->assertTrue(count($split) > 0);
        return null;
    }

    public function testPinyin()
    {
        $test = new Pinyin();

        $content = $test->getPinyin('你好拼音');
        $this->comment($content);
        $this->assertTrue(!empty($content));
    }

    /**
     * 测试创建索引
     *
     * @return null
     */
    public function testIndex()
    {
        // TODO 测试拼音 的 储存

        // TODO 拼音的读取

        // TODO 更多的插件

        $bank = new Bank();
        $bank->robAll();
        $sentences = self::getData();

        foreach ($sentences as $sentence)
        {
            $bank->deposit(new Coin($sentence));
        }

        $this->assertTrue(true);
        return null;
    }

    /**
     * 搜索测试
     *
     * @return null
     */
    public function testSearch()
    {
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
            's'
        ];
        foreach($words as $word)
        {
            $results = $bank->withdrawal($word);
            $this->comment('result..'.$word);
            foreach($results as $result){
                $this->info($word . '=>' . $result);
            }
        }
        $this->assertTrue(true);

        return null;
    }

    /**
     * 设计文件
     *
     * @cover baseStore::store
     *
     */
    public function testFile()
    {
        return null;
    }

    /**
     * 设计单个Coin 健康
     *
     * @return null
     */
    public function testCoin()
    {
        // TODO  ...

        return null;
    }
}


