<?php

use Woola\Searchsuggest\SearchClient;

class ssTest extends PHPUnit_Framework_TestCase
{
    //protected $Client;
    //protected $config;

    protected function setUp()
    {
        //$_ENV['SEARCH_KEY_TYPE'] = 'elastsearch';
        //$config = require __DIR__ . '/../src/config/config.php';
        //$this->Client = new ElasticsearchSearch();
    }

    protected function tearDown()
    {
        //$this->Client = NULL;
    }

    public function testLoadword()
    {

        $s=new SearchClient();
        $ss=$s->getSuggest("gogo");
        echo "on test";
        var_dump($ss);
    }
    public function testLog(){}

}


