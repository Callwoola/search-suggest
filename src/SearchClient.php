<?php
namespace Callwoola\Searchsuggest;

use Callwoola\Searchsuggest\lib\SearchCache;
use Callwoola\Searchsuggest\lib\AnalyzeManage;

/**
 *  KEY_TYPE select adapter
 */
class SearchClient
{
    /**
     * 默认配置
     */
    public function __construct()
    {
        $_ENV['REDIS_DEFAULT_HOST'] = '127.0.0.1';
        $_ENV['REDIS_DEFAULT_PORT'] = '6379';
    }
s
    /**
     * 搜索提示 补全 接口
     */
    public function getSuggest($keyword = "")
    {
        if ($keyword === '') return [];
        return SearchCache::init()->searchPinyin($keyword);
    }

    /**
     * 添加 更新 缓存服务
     */
    public function indexDict($arr = [])
    {
        $AnalyzeManage = new AnalyzeManage();
        $AnalyzeManage->setDictArr($arr);
        $wordsInit = $AnalyzeManage->getCacheInitials();
        $wordsPinyin = $AnalyzeManage->getCachePinyin();
        $wordsFuzzySoundPinyin = $AnalyzeManage->getCacheFuzzySoundPinyin();
        $cacheData = $AnalyzeManage->mergeData($wordsInit, $wordsPinyin, $wordsFuzzySoundPinyin);
        SearchCache::init()->setPinyinIndex($cacheData);

    }
}

