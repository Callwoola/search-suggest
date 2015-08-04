<?php
namespace Callwoola\Searchsuggest;

use Callwoola\SearchSuggest\lib\AnalyzeManage;
use Callwoola\SearchSuggest\lib\SearchCache;

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


    /**
     * 搜索提示 补全 接口
     * @param string $keyword
     * @return array
     */
    public function getSuggest($keyword = "")
    {
        if ($keyword === '') return [];
        return SearchCache::init()->searchAll($keyword);
    }


    /**
     * 添加 更新 缓存服务
     * @param array $arr 需要分词的 arr
     * @param array $localDict 本地化分词 arr
     */
    public function indexDict($arr = [], $localDict = [], $open_fzs = false)
    {
        $AnalyzeManage = new AnalyzeManage();
        $AnalyzeManage->setDictArr($arr);

        //添加可以添加 私有词库
        $AnalyzeManage->addSelfDict($localDict);

        $wordsInit = $AnalyzeManage->getCacheInitials();
        $wordsPinyin = $AnalyzeManage->getCachePinyin();

        // Cacheing.. chinese pinyin keys
        if ($open_fzs == true) {
            $wordsFuzzySoundPinyin = $AnalyzeManage->getCacheFuzzySoundPinyin();
            // Added Chinese Cache

            $cacheData = $AnalyzeManage->mergeData($wordsInit, $wordsPinyin, $wordsFuzzySoundPinyin);
        } else {
            $cacheData = $AnalyzeManage->mergeData($wordsInit, $wordsPinyin);
        }

        SearchCache::init()->setPinyinIndex($cacheData);

        // Cacheing.. chinese keys
        $wordsChinese = $AnalyzeManage->getCacheChinese();
        SearchCache::init()->setChineseIndex($wordsChinese);
    }
}

