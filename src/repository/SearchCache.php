<?php

namespace Callwoola\SearchSuggest\repository;



class CacheManage
{


    public function fire()
    {
        // TODO optimize code

        $start = microtime(true);
        $this->info('Update Callwoola-search Cache...');
        $indexManage = new IndexManage();
        $indexManage->byElasticsearch();
        $this->info("Create Elasticsearch Index successful!");
        $AnalyzeManage = new AnalyzeManage();
        $cacheInitials = $AnalyzeManage->getCacheInitials();
        $cachePinyin = $AnalyzeManage->getCachePinyin(1);
        $cacheFuzzySoundPinyin = $AnalyzeManage->getCacheFuzzySoundPinyin(1);
        $testdata = $AnalyzeManage->mergeData($cacheInitials, $cachePinyin, $cacheFuzzySoundPinyin);
        SearchCache::init()->setPinyinIndex($testdata);
        $this->info("Create Pinyin Cache Index successful!");
        $chineseList = $AnalyzeManage->getCacheChinese();
        SearchCache::init()->setChineseIndex($chineseList);
        $timeElapsed = microtime(true) - $start;
        $this->info("Create Chinese Cache Index successful!");
        $this->info(" Total time: $timeElapsed second");
    }

    protected static $config = [
        'key' => 'Callwoolasearch-',
        'index' => 'woola',//default
        'index_num' => 'woola',
        'index_chinese' => 'woola_chinese',
        'returnLimit' => 10,
    ];
    protected static $client;
    protected static $instance;

    protected function __construct()
    {
        $redisConfig = $this->getRedisConfig();
        self::$client = new Client($redisConfig);
    }

    /**
     * 初始化配置
     */
    public static function init()
    {
        if (!self::$instance) {
            self::$instance = new self();
            return self::$instance;
        }
        return self::$instance;
    }

    /**
     * 初始化配置
     */
    public static function getClient()
    {
        return self::$client;
    }

    /**
     *  设置纯拼音缓存
     * @return void
     */
    public function setPinyinIndex($value, $indexName = null)
    {
        foreach ($value as $k => $words) {
            self::$client->del(self::keyLocalSet($k));
            foreach ($words as $singleWord) {
                if (count(Pinyin::init()->stringToArray($singleWord)) >= 2) {
                    self::$client->sadd(
                        self::keyLocalSet($k),
                        //self::$config['key'] .($indexName === null ? self::$config['index'] : $indexName) . ':' . $k,
                        $singleWord
                    );
                }
            }
        }
        //create count list
    }

    /**
     *  设置中文拼音缓存
     * @return void
     */
    public function setChineseIndex($value, $indexName = null)
    {
        foreach ($value as $k => $words) {
            self::$client->del(self::keyLocalSet($words, self::$config['index_chinese']));
            self::$client->set(self::keyLocalSet($words, self::$config['index_chinese']), $words);
        }
    }

    /**
     *  get Cache
     * @return array $returnList
     */
    public function searchPinyin($keyword, $isEachWord = 0, $indexName = null)
    {
        //find keys
        //get key list
        $keyword = $this->keyLocalSet(strtolower($keyword)."*");
        $keyList = self::$client->keys($keyword);
        $returnList = [];
        foreach ($keyList as $keyString) {
            $list = self::$client->smembers($keyString);
            foreach ($list as $eachString) {
                if ($isEachWord == 0) {
                    $returnList[] = $eachString;
                } else {
                    if (strlen($eachString) > 3) {
                        $returnList[] = $eachString;
                    }
                }
            }
        }
        $searchList = array_slice(array_unique($returnList), 0, self::$config['returnLimit']);
        $returnList = [];
        foreach ($searchList as $key => $word) {
            $returnList[] = [
                'title' => $word,
                'count' => self::getCountNum($word),
            ];
        }
        return $returnList;
    }

    /**
     *  get Cache
     * @return array $returnList
     */
    public function searchChinese($keyword, $isEachWord = 0, $indexName = null)
    {
        $keyword = $this->keyLocalSet('*'.$keyword.'*',self::$config['index_chinese']);
        $keyList = self::$client->keys($keyword);
        $searchList = [];
        foreach ($keyList as $keyString) {
            $searchList[]=self::$client->get($keyString);
        }
        $searchList = array_slice(array_unique($searchList), 0, self::$config['returnLimit']);
        $returnList = [];
        foreach ($searchList as $key => $word) {
            $returnList[] = [
                'title' => $word,
                'count' => self::getCountNum($word),
            ];
        }
        return $returnList;
    }


    /**
     * 暂时搜索建议 数量统计都为1
     * @param string $key
     * @return int
     */
    public static function getCountNum($key)
    {
        $key = self::keyLocalSet($key, self::$config['index_num']);
        if (self::init()->getClient()->get($key) === null) {
            $client = ClientBuilder::create()->build();
            $body['from'] = 0;
            $body['size'] = 1000;
            $body['query']['match'] = ['title' => $key];
            $params = [
                'index' => 'goods',
                'type' => 'goods',
                'body' => $body
            ];
            $response = $client->search($params);
            self::init()->getClient()->set($key, count($response['hits']['hits']));
            return (int)self::init()->getClient()->get($key);
        }
        return (int)self::init()->getClient()->get($key);
    }


    private static function keyLocalSet($keyword, $indexName = null)
    {
        return self::$config['key'] . ($indexName === null ? self::$config['index'] : $indexName) . ':' . $keyword;
    }

    private static function keyLocalGet($keyword, $indexName = null)
    {
        return str_replace(self::$config['key'] . ($indexName === null ? self::$config['index'] : $indexName) . ':', '', $keyword);
    }
}

