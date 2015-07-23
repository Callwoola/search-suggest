<?php

use Callwoola\Search\lib\Indexdata\IndexManage;

class CreateIndexTest extends PHPUnit_Framework_TestCase
{
    /**
     * elastic search Index creation test
     */
    public function testElasticSearchCreateIndex()
    {
        $indexManage = new IndexManage();
        $isCreate = $indexManage->byElasticsearch();
        $this->assertEquals(true, $isCreate, "elastic search Index creation failed");
    }
}