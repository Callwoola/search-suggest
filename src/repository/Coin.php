<?php

namespace Callwoola\SearchSuggest\repository;

/**
 * 分析每个字符串的内容
 * 方便管理长句子
 * TODO 分词以及拼音管理
 *
 * @package Callwoola\SearchSuggest\repository
 */
class Coin implements CoinInterface
{
    /**
     * 搜索名称
     *
     * @var
     */
    protected $name;

    /**
     * 返回内容
     *
     * @var
     */
    protected $value;

    /**
     * @param $name
     */
    public function __construct($name = '')
    {

        if (!empty($name)) {
            $this->setName($name);
        }

        $value = Analyze::getResult($name);

        if (!empty($value)) {
            $this->setValue($value);
        }
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }


    /**
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }


    /**
     * @param array $value
     * @return void
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}