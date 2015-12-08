<?php
namespace SuggestTest;

use Callwoola\SearchSuggest\Suggest;

class SearchTest extends BaseTest
{

    public $suggest;

    protected function setUp()
    {
        $this->suggest = new Suggest();
    }


    public function testSearch()
    {
        $this->info('start search...');
        $strings = $this->suggest->search('dwmb');
        var_dump($strings);
    }
}


