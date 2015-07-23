<?php

use Callwoola\Search\lib\ElasticsearchSearch;
use Elasticsearch\ClientBuilder;
use Callwoola\Search\lib\Indexdata\ElasticsearchUrl;
use Callwoola\Search\lib\Indexdata\DataManage;

class ElasticsearchTest extends PHPUnit_Framework_TestCase
{
    protected $Client;
    protected $config;

    protected function setUp()
    {
        $_ENV['SEARCH_KEY_TYPE'] = 'elastsearch';
        //$config = require __DIR__ . '/../src/config/config.php';
        $this->Client = new ElasticsearchSearch();
    }

    protected function tearDown()
    {
        $this->Client = NULL;
    }

    public function testChineseCacheSearch()
    {
        $result = $this->Client->searchSuggestion("沙");
        $this->assertGreaterThan(0, count($result), "未找到DOC");
    }

    /**

    */
    public function testUpindex()
    {
        $client=new ElasticsearchUrl();
        $this->assertTrue($this->Client->updateIndex());
        sleep(5);//wait for create index
    }

    public function testSearch()
    {
        $result = $this->Client->search($_GET['keyword']);
        $this->assertEquals("OK", $result['status'], "返回错误");
        $this->assertGreaterThan(0, (int)$result['result']['total'], "未找到DOC");
    }

    public function testSuggestionSearch()
    {
        $result = $this->Client->searchSuggestion("s");
        $this->assertGreaterThan(0, count($result), "搜索结果为空");
    }

    public function testConditionSearch()
    {
        $this->Client->addCondition("price", "<", "500");
        $this->Client->addCondition("price", ">", "200");
        $this->Client->addSorts("updated_at", "desc");
        $this->Client->setPageSize(2);
        $result = $this->Client->search($_GET['keyword']);
        //var_dump($result);
        //exit();
        $num = rand(0, count($result['result']['items']) - 1);
        $price = (int)$result['result']['items'][$num]['price'];
        $this->assertFalse(!($price < 500 and $price > 200));
    }
}


