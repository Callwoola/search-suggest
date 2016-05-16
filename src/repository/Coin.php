<?php

namespace Callwoola\SearchSuggest\repository;

use Callwoola\SearchSuggest\Pinyin;
use SebastianBergmann\RecursionContext\Exception;

/**
 * 分析数据内容
 *
 * @package Callwoola\SearchSuggest\repository
 */
class Coin
{
    use Key;

    protected $name    = '';
    protected $account = [];
    protected $type    = '';

    /**
     * 解析一个 coin
     *
     * @param $coin
     * @throws \Exception
     */
    protected function __construct(Array $coin)
    {
        if (!(
            isset($coin['name']) AND !empty($coin['name']) AND
            isset($coin['data']) AND is_array($coin['data']) AND
            isset($coin['type']) AND !empty($coin['type'])
        )) {
            throw new \Exception('Requisite data is empty');
        }

        $this->word = $coin['name'];

        $this->setName($coin['name']);
        $this->setAccount($coin['data']);
        $this->setType($coin['type']);
    }

    public static function parse($coin)
    {
        return new self($coin);
    }

    /**
     * @param  $data
     */
    public function setAccount($data)
    {
        $this->account = $data;
    }

    /**
     * @param  $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }


    /**
     * @param  $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return array
     */
    public function getAccount()
    {
        $this->account['raw_name'] = $this->name;

        return $this->account;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    ///**
    // * 生成拼音
    // *
    // * @return string
    // */
    //public function getCharName()
    //{
    //    return preg_replace('/[[:punct:]]/u', '', Pinyin::getPinyin($this->name));
    //}

    /**
     * 得到原始名称
     *
     * @return string
     */
    public function getRawName()
    {
        return $this->name;
    }

    ///**
    // * 返回干净的字符串
    // *
    // * @return string
    // */
    //public function getClearName()
    //{
    //    return preg_replace('/[[:punct:]]/u', '', $this->name);
    //}
}