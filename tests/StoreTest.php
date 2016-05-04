<?php
namespace SuggestTest;

use Callwoola\SearchSuggest\Suggest;
use SuggestTest\Support\BaseTest;

/**
 * @author  Neo <call@woola.net>
 * @package SuggestTest
 */
class BankTest extends BaseTest
{
    /**
     * 测试创建索引
     *
     * @return null
     */
    public function testIndex()
    {
        $suggest = new Suggest($this->connect);

        $suggest->clear();

        foreach ($this->getJson() as $item)
        {
            $this->info($item['name']);
            $suggest->push($item);
        }

        $this->assertTrue(true);
    }
}
