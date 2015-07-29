<?php
namespace Callwoola\Searchsuggest;

use Callwoola\Searchsuggest\lib\SearchCache;

/**
 *  KEY_TYPE select adapter
 */

class SearchClient
{
    /**
     * 搜索提示 补全 接口
    */
	function getSuggest($keyword=""){
        return SearchCache::init()->searchPinyin($keyword);
	}
}

