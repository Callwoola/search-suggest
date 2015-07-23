<?php
namespace  Callwoola\Searchsuggest\lib;

//use Elasticsearch\ClientBuilder;
//use Mockery\CountValidator\Exception;

/**
 *
 * 抛开烦恼  直接使用 ES
 * Class ElasticsearchUrl
 * @package Woola\Searchsuggest\lib\ElasticsearchUrl
 */
class ElasticsearchUrl
{
    /**
     * host
     * @var string
     */
    protected $host = "";

    /**
     * 查询索引
     * @var string
     */
    protected $index = "";

    /**
     * 查询借口
     * @var string
     */
    protected $action = "";

    /**
     * 请求参数
     * @var string
     */
    protected $param = [];

    /**
     * 请求地址
     * @var string
     */
    protected $url = "";

    /**
     * @param string $host
     * @return $this
     */
    public function setHost($host = "")
    {
        if ($host == '') {
            $this->host = $host . '/';
        } else {
            $this->host = 'http://127.0.0.1:9200/';//default host
        }
        return $this;
    }

    /**
     * @param string $index
     * @return $this
     */
    public function setIndex($index = "")
    {
        $this->index = $index . '/';
        return $this;
    }

    /**
     * @param string $action
     * @return $this
     */
    public function setAction($action = "")
    {
        $this->action = $action . '?';
        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     * @return $this
     */
    public function addParam($name = "", $value = "")
    {
        $this->param[] = [$name, $value];
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        $this->url = $this->host . $this->index . $this->action;
        foreach ($this->param as $name => $value) {
            $this->url .= $value[0] . '=' . $value[1];
            if ($this->param[count($this->param) - 1][0] != $value[0]) {
                $this->url .= '&';
            }
        }
        $this->param = [];
        return $this->url;
    }

    /**
     * @param string $type
     * @return array
     */
    public function get($type = 'GET')
    {
        //return json_decode(file_get_contents($this->getUrl()));
        return $this->curl($this->getUrl(), $type);
    }

    /**
     * delete elasticsearch index
     * @param string $index
     * @return array
     */
    public function delete($index = '')
    {
        if ($index != '' or $this->index == '') {
            $result = $this->curl($this->host . $index, 'delete');
        } else {
            $result = $this->curl($this->getUrl(), 'delete');
        }
        if (isset($result->error) or $result->status == 404) {
            return false;
        }
        return true;
    }

    /**
     * 直接请求 elasticsearch url 返回 json
     * @param $path
     * @param $type
     * @return array
     */
    protected function curl($url, $type)
    {
        $result = function () use ($url, $type) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($type));
            $result = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if($httpCode>200){
                return '{"error":500}';
            }
            return $result;
        };
        return json_decode($result());
    }
}
