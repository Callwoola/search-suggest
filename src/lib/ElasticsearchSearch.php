<?php
namespace Callwoola\Search\lib;

use Elasticsearch\ClientBuilder;
use Callwoola\Search\lib\Indexdata\IndexManage;
use Callwoola\Search\Config\Configuration;
class ElasticsearchSearch implements SearchInterface
{
    use Configuration;
    /**
     * aliyun 应用名称
     * @var string
     */
    protected $appName;

    /**
     * aliyun 索引名称
     * @var string
     */
    protected $indexName;

    /**
     * aliyun 高亮配置
     * @var string
     */
    protected $elementPrefix;

    /**
     * aliyun 高亮配置
     * @var string
     */
    protected $elementPostfix;

    /**
     * aliyun currentPage
     * @var string
     */
    protected $currentPage;

    /**
     * aliyun pageSize
     * @var string
     */
    protected $pageSize = 10;

    /**
     * sort 条件组
     * @var string
     */
    protected $sort = [];

    /**
     * 区间条件
     * @var string
     */
    protected $intervals = [];

    /**
     * url
     * @var string $url
     */
    protected $hosts = '';

    /**
     * url
     * @var Object $client
     */
    protected $client;

    /**
     *  默认 地址为 127.0.0.1:9200
     *  如果 elasticSearch 未打开 或者服务错误 将返回false 并使用 aliyun search
     * @param array config
     */
    public function __construct()
    {
        $elasticsearchConfig=$this->getElasticsearchConfig();
        $highLightConfig=$this->getHighLightConfig();
        $this->appName = $elasticsearchConfig['index'];
        $this->indexName = $elasticsearchConfig['type'];
        $this->elementPostfix = $highLightConfig['element_postfix'];
        $this->elementPrefix = $highLightConfig['element_prefix'];
        $urls = $elasticsearchConfig['url'];
        if (empty($urls)) {
            $this->client = ClientBuilder::create()->build();
        } else {
            $hosts[] = $urls;
            $clientBuilder = ClientBuilder::create();   // Instantiate a new ClientBuilder
            $clientBuilder->setHosts($hosts);           // Set the hosts
            $this->client = $clientBuilder->build();
        }
    }

    /**
     * 单个doc 添加
     * @param array $Fields 字段
     * @param string $appName 应用名称
     * @param string $Index 索引
     * @return bool
     */
    public function upOne($body = [], $index = "goods", $type = "goods", $id = null)
    {
        $params = [
            'index' => $index,
            'type' => $type,
            'body' => $body
        ];
        if (!empty($id)) {
            $params['id'] = $id;
        }
        $response = $this->client->index($params);
        return $response;
    }

    /**
     * @return bool
     */
    public function  updateIndex()
    {
        $IndexManage = new IndexManage();
        return $IndexManage->updateGoodsIndex("elasticsearch", $this->appName, $this->indexName);
    }

    /**
     * @return array
     */
    public function searchSuggestion($keyword, $field = "search")
    {
        //$field => title & subtitle
        //在 更新索引的时候两个 字段 已经拼接在一起 title
        if(preg_match('/^[a-z|A-Z|0-9]{1,20}/', $keyword)) {
            return  SearchCache::init()->searchPinyin($keyword);
        }else{
//            var_dump($keyword);exit();
            return  SearchCache::init()->searchChinese($keyword);
        }
        exit();
        $fields = ['id', 'title', 'sku_id', 'sku_sn'];
        $body = [];
        $body['fields'] = $fields;
        if (count($this->intervals) > 0) {
            foreach ($this->intervals as $v) {
                $body['query']['filtered']['filter']['range'][$v[0]][$v[1]] = $v[2];
            }
            $body['query']['filtered']['query']['match'] = [$field => $keyword];
        } else {
            $body['query']['match'] = [$field => $keyword];
        }
        $params = [
            'index' => $this->appName,
            'type' => $this->indexName,
            'body' => $body
        ];
        $params['body']['size'] = $this->pageSize;
        $params['body']['from'] = $this->pageSize * $this->currentPage;
        foreach ($this->sort as $v) {
            $params['body']['sort'][$v[0]] = $v[1];
        }
        $response = $this->client->search($params);
        $result['status'] = "OK";
        $result['result']['total'] = count($response['hits']['hits']);
        $result['result']['viewtotal'] = count($response['hits']['hits']) >= $this->pageSize ? $this->pageSize : count($response['hits']['hits']);
        $result['result']['items'] = [];
        foreach ($response['hits']['hits'] as $k => $v) {
            $resultClear = [];
            foreach ($fields as $field) {
                $resultClear[$field] = $response['hits']['hits'][$k]['fields'][$field][0];
            }
            $resultClear['index_name'] = $this->appName;
            $resultClear['result_count'] = 1;
            $result['result']['items'][] = $resultClear;

        }
        unset($response);
        return $result;
    }

    /**
     * @param string $Keyword 关键词
     * @param string $field 字段
     * @return array
     */
    public function search($keyword, $field = "search")
    {
        //$field => title & subtitle
        //在 更新索引的时候两个 字段 已经拼接在一起 title
        $body = [];
        if (count($this->intervals) > 0) {
            foreach ($this->intervals as $v) {
                $body['query']['filtered']['filter']['range'][$v[0]][$v[1]] = $v[2];
            }
            $body['query']['filtered']['query']['match'] = [$field => $keyword];
        } else {
            $body['query']['match'] = [$field => $keyword];
        }
        $params = [
            'index' => $this->appName,
            'type' => $this->indexName,
            'body' => $body
        ];
        $params['body']['size'] = $this->pageSize;
        $params['body']['from'] = $this->pageSize * $this->currentPage;
        foreach ($this->sort as $v) {
            $params['body']['sort'][$v[0]] = $v[1];
        }
        $response = $this->client->search($params);
        $result['status'] = "OK";
        $result['result']['total'] = $response['hits']['total'];
        $result['result']['items'] = [];
        foreach ($response['hits']['hits'] as $k => $v) {
            $result['result']['items'][] = $response['hits']['hits'][$k]['_source'];
        }
        unset($response);
        return $result;
    }

    /**
     * @param string $field 字段
     * @param string $sortChar 排序
     */
    public function addSorts($field, $sortChar)
    {
        $this->sort[] = [$field, $sortChar];
        return $this;
    }

    /**
     * 设置 添加区间条件
     *
     */
    public function addCondition($field, $condition, $Parameters)
    {
        switch ($condition) {
            case '>':
                $condition = "gt";
                break;
            case '>=':
                $condition = "gte";
                break;
            case '<':
                $condition = "lt";
                break;
            case '<=':
                $condition = "lte";
                break;
        }
        $this->intervals[] = [$field, $condition, (int)$Parameters];
        return $this;
    }

    /**
     *  设置当前页面size
     * @param int $size
     */
    public function setPageSize($size)
    {
        $this->pageSize = $size;
        return $this;
    }

    /**
     * 设置当前页面
     * @param int $Page
     */
    public function setCurrentPage($Page = 0)
    {
        if ($Page > 0) {
            $Page = $Page - 1;
        }
        $this->currentPage = $Page;
        return $this;
    }

    /**
     *  配置分词语器
     * @param int $anaylzer
     */
    public function anaylzer($anaylzer = "ik")
    {
        $this->anaylzer = $anaylzer;
        return $this;
    }
}
