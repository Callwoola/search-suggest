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
        $this->info("start store...");

        $suggest = new Suggest($this->connect);

        $suggest->clear();

        $storeRecords = $this->getJson();

        foreach ($storeRecords as $item)
        {
            $item['type'] = self::TYPE_ONE;
            $this->info($item['name']);
            $suggest->push($item, 'test');
        }
        $this->info('withdrawal ' . count($storeRecords) . ' coin');

        $this->assertTrue(true);
    }
}
