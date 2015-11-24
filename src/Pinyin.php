<?php

namespace Callwoola\SearchSuggest;

use Overtrue\Pinyin\Pinyin as BasePinyin;

/**
 * Class Pinyin
 * @package Callwoola\SearchSuggest
 */
class Pinyin
{
    /**
     * @var Pinyin
     */
    protected $pinyin;

    /**
     * @param $word
     * @return mixed
     */
    public function getPinyin($word)
    {
        BasePinyin::set('accent',false);
        return BasePinyin::trans($word);
    }
}