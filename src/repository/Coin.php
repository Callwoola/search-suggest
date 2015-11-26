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

    protected $sentence = '';

    /**
     * @param $string
     */
    public function __construct($string = '')
    {
        $this->setSentence($string);
    }

    /**
     * @return mixed
     */
    public function getSentence()
    {
        return $this->sentence;
    }

    /**
     * @param string $sentence
     * @return void
     */
    public function setSentence($sentence)
    {
        $this->sentence = $sentence;
    }

}