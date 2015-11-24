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
     * 模糊音转化
     * @var array
     */
    public static $fuzzySoundTranslate = [
        'first' => [
            'z' => 'zh',
            'c' => 'ch',
            's' => 'sh',
            'l' => 'n',
            'f' => 'h',
            'r' => 'l',
        ],
        'last' => [
            'an' => 'ang',
            'en' => 'eng',
            'in' => 'ing',
            'ian' => 'iang',
            'uan' => 'uang',
        ]
    ];

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