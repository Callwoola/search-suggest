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
    public static function getPinyin($word)
    {
        BasePinyin::set('accent',false);
        BasePinyin::set('delimiter', '');
        return BasePinyin::trans($word);
    }

    public static function getPinyinFirst($word)
    {
        BasePinyin::set('accent',false);
        BasePinyin::set('delimiter', '');
        return BasePinyin::letter($word);
    }
}