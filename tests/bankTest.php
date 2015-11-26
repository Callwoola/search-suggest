<?php
namespace SuggestTest;


use Callwoola\SearchSuggest\repository\Coin;
use phpSplit\Split\Split;
use Callwoola\SearchSuggest\Pinyin;
use Callwoola\SearchSuggest\Container;
use Callwoola\SearchSuggest\repository\Bank;
use Callwoola\SearchSuggest\StoreAdapter\Store;
use Callwoola\SearchSuggest\Currency\PinyinCurrency;

/**
 * Class BankTest
 * @package SuggestTest
 */
class BankTest extends baseTest
{

    public function testOne()
    {
        $bank = new Bank();
        $bank->deposit(new Coin('康师傅牛肉面'));
        $bank->deposit(new Coin('苹果手机iphone6'));

        $this->assertTrue(true);
    }
//
//    /**
//     * @return null
//     */
//    public function testSplit()
//    {
//        $this->info('start php-split testing ...');
//        $split = new Split();
//        $split = $split->start("康师傅牛肉面");
//        foreach ($split as $word) {
//            $this->info($word);
//        }
//        $this->assertTrue(count($split) > 0);
//
//        return null;
//    }
//
//    public function testPinyin()
//    {
//        $test = new Pinyin();
//
//        $content = $test->getPinyin('你好拼音');
//        $this->comment($content);
//        $this->assertTrue($content);
//    }
//
//    /**
//     * 测试创建索引
//     *
//     * @return null
//     */
//    public function testIndex()
//    {
//        // TODO 测试拼音 的 储存
//
//        // TODO 拼音的读取
//
//        // TODO 更多的插件
//
//        //        $container = new Container();
//        //
//        //        $container->bank(function () {
//        //            return (new Bank(new PinyinCurrency))->getCoin();
//        //        });
//
//        return null;
//    }
//
//    /**
//     * 设计文件
//     *
//     * @return array
//     */
//    private function getFile()
//    {
//        return [[new Store]];
//    }
//
//    /**
//     * 设计文件
//     *
//     * @cover baseStore::store
//     *
//     */
//    public function testFile()
//    {
//        //        foreach ($this->getFile() as $test) {
//        //            $Bank = new Bank($test);
//        //            echo $Bank->getName();
//        //        }
//
//        return null;
//    }
//
//    /**
//     * 设计单个Coin 健康
//     *
//     * @return null
//     */
//    public function testCoin()
//    {
//        // TODO  ...
//
//        return null;
//    }
}


