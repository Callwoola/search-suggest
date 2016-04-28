<?php

namespace Callwoola\SearchSuggest\repository;

use Callwoola\SearchSuggest\Pinyin;

/**
 * 分析数据内容
 *
 * @package Callwoola\SearchSuggest\repository
 */
class Coin
{
    protected $name    = '';
    protected $account = [];

    /**
     * 解析一个 coin
     *
     * @param $coin
     */
    protected function __construct(Array $coin)
    {
        $this->setName($coin['name']);
        $this->setAccount($coin['data']);
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
     * @return array
     */
    public function getAccount()
    {
        $this->account['raw_name'] = $this->name;

        return $this->account;
    }

    /**
     * 生成拼音
     *
     * @return string
     */
    public function getCharName()
    {
        return preg_replace('/[[:punct:]]/u', '', Pinyin::getPinyin($this->name));
    }

    /**
     * 得到原始名称
     *
     * @return string
     */
    public function getRawName()
    {
        return $this->name;
    }

    /**
     * 返回干净的字符串
     *
     * @return string
     */
    public function getClearName()
    {
        return preg_replace('/[[:punct:]]/u', '', $this->name);
    }
}