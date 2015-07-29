<?php

namespace Callwoola\Searchsuggest\lib;

//use Callwoola\Searchsuggest\SDK\CloudsearchIndex;
//use Callwoola\Searchsuggest\SDK\CloudsearchDoc;
//use Elasticsearch\ClientBuilder;
//use Illuminate\Database\Capsule\Manager as DB;
//use Elasticsearch\CountValidator\Exception;

class IndexManage
{

    /**
     * update goods 数据
     * @return bool
     */
    public function updateGoodsIndex($Adapter = "els", $index, $type)
    {
        return $this->byElasticsearch($index, $type);
    }



    /**
     * update elasticsearch
     * @return bool
     */
    public function byElasticsearch($index = 'woola', $type = 'woola')
    {
//
//
//        $client = ClientBuilder::create()->build();
//
//        $dataManage = new DataManage();
//        $goodsData = $dataManage->getGoodsRecord();
//
//        foreach ($goodsData as $k => $v) {
//            $v = (object)$v;
//            $item = [];
//            $item['index'] = $appName;
//            $item['type'] = $index;
//            $item['id'] = $v->pid;
//            $item["body"] = [
//                "id" => $v->pid,
//                "search" => $v->title . $v->subtitle . $v->attribute_name,
//            ];
//            $response = $client->index($item);
//
//        }
        return true;

    }

}