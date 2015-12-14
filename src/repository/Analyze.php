<?php

namespace Callwoola\SearchSuggest\repository;

use Callwoola\SearchSuggest\Currency\Sort;
use Callwoola\SearchSuggest\Pinyin;
use phpSplit\Split\Split;

class AccountIterator implements \Iterator
{
    private $accounts = [];

    public function __construct($accounts)
    {
        if (is_array($accounts)) {
            $this->accounts = $accounts;
        }
    }

    public function current()
    {
        return current($this->accounts);
    }

    public function next()
    {
        return key($this->accounts);
    }

    public function key()
    {
        return next($this->accounts);
    }

    public function valid()
    {
        $account = key($this->accounts);

        return ($account !== null && $account !== false);
    }

    public function rewind()
    {
        reset($this->accounts);
    }
}

/**
 * 通过 php-split 词库 进行分词，同时检查Callwoola.dat 是否有特定的分词条件
 *
 */
class Analyze
{
    protected $string;

    protected $account;

    private function __construct()
    {
    }

    public static function start($string)
    {
        // TODO 分词+原句
        $split   = new Split();
        $strings = $split->start($string);
        self::filter($strings);

        // abc
        // a
        // a - b
        // a - b - c

        $strings[] = $string;

        // TODO 过滤

        return self::generate($strings);
    }


    /**
     * 过滤句子
     *
     * @param $strings
     */
    private static function filter(&$strings)
    {
        foreach ($strings as $key => $string)
        {
            // 空字符或者单字不能进入缓存 和 符号
            if (empty($string) OR strlen($string) > 3)
            {
                unset($strings[$key]);
                continue;
            }

            $strings[$key] = explode('/',$string)[0];
        }
    }

    /**
     * ...
     *
     * @param $strings
     * @return array
     */
    public static function generate($strings)
    {
        // TODO 逐个连接字符

        $generates = [];
        foreach ($strings as $string)
        {
            // 添加
            $name = Pinyin::getPinyin($string) . '@' . Pinyin::getPinyinFirst($string) ;
            $info = [];

            $account = new Account();
            $account->setName($name);
            $account->addAmount($string,$info);
            $generates[] = $account;
        }

        return $generates;
    }


    /**
     * @param $word
     * @return string
     */
    public static function parse($word)
    {
        $word = Pinyin::getPinyin($word);

        return strtolower($word);
    }


    public static function sort($origin,array $accounts)
    {
        $sorter = new Sort($origin, $accounts);
        $results = $sorter->all();

        return $results;
//        return implode(', ', $results);
//
//        usort($matches, function ($a, $b) use ($word) {
//            return similar_text($word,$a) - similar_text($word, $b);
//        });
    }

    /**
     * 缓存全拼的 模糊音
     * @param int $isAll
     * @return array $cacheArray
     */
    public function getCacheFuzzySoundPinyin($isAll = 0, $dict = null)
    {
        $fss = Pinyin::$fuzzySoundTranslate;
        //$cacheArray = $this->CacheInitials($isAll);
        $pinyin = Pinyin::init();
        if ($dict === null) {
            $dict = $this->getAnalyzeDict();
        }

        if ($isAll == 1) {
            //each word
            foreach ($dict as $words) {
                $stringArray = $pinyin->stringToArray($words);
                $linkpinyin  = '';
                foreach ($stringArray as $k => $word) {
                    $tranPinyin                = $pinyin->getPinyin($word);
                    $linkpinyin                = $linkpinyin . $tranPinyin;
                    $cacheArray[$linkpinyin][] = $words;
                    if ($k > 0) {
                        $cacheArray[$linkpinyin][] = $words;
                    }
                }
            }
        } else {
            //first word
            foreach ($dict as $v) {
                $stringArray        = $pinyin->stringToArray($v);
                $key                = $pinyin->getPinyin($stringArray[0]);
                $cacheArray[$key][] = $v;
            }
        }

        $selfToRelative = [];
        $relativeToSelf = [];
        //exchange fuzzy sound
        //self to relative
        foreach ($cacheArray as $key => $words) {
            //check exist fuzzy sound
            foreach ($fss['first'] as $self => $relative) {
                //case first self to relative
                if (preg_match("/^$self+[^h]/i", $key) === 1) {
                    //exist relative letter
                    $keyRelative = str_replace($self, $relative, $key);
                    if (!array_key_exists($keyRelative, $cacheArray)) {//copy
                        $selfToRelative[$keyRelative] = $cacheArray[$key];
                    }
                    if (array_key_exists($keyRelative, $cacheArray)) {//merge
                        $merge                        = array_unique(array_merge($cacheArray[$keyRelative], $cacheArray[$key]));
                        $selfToRelative[$keyRelative] = $merge;
                    }
                }
            }
            foreach ($fss['last'] as $self => $relative) {
                if (preg_match("/$self$/i", $key) === 1) {
                    //exist relative letter
                    $keyRelative = str_replace($self, $relative, $key);
                    if (!array_key_exists($keyRelative, $cacheArray)) {//copy
                        $selfToRelative[$keyRelative] = $cacheArray[$key];
                    }
                    if (array_key_exists($keyRelative, $cacheArray)) {//merge
                        $merge                        = array_unique(array_merge($cacheArray[$keyRelative], $cacheArray[$key]));
                        $selfToRelative[$keyRelative] = $merge;
                    }
                }
            }
        }

        //relative to self
        foreach ($cacheArray as $key => $words) {
            //check exist fuzzy sound
            foreach ($fss['first'] as $self => $relative) {
                //case first self to relative
                if (preg_match("/^$relative/i", $key) === 1) {
                    //exist relative letter
                    $keyRelative = str_replace($relative, $self, $key);
                    if (!array_key_exists($keyRelative, $cacheArray)) {//copy
                        $relativeToSelf[$keyRelative] = $cacheArray[$key];
                    }
                    if (array_key_exists($keyRelative, $cacheArray)) {//merge
                        $merge                        = array_unique(array_merge($cacheArray[$keyRelative], $cacheArray[$key]));
                        $relativeToSelf[$keyRelative] = $merge;
                    }
                }
            }
            foreach ($fss['last'] as $self => $relative) {
                //case first self to relative
                if (preg_match("/$relative$/i", $key) === 1) {
                    //exist relative letter
                    $keyRelative = str_replace($relative, $self, $key);
                    if (!array_key_exists($keyRelative, $cacheArray)) {//copy
                        $relativeToSelf[$keyRelative] = $cacheArray[$key];
                    }
                    if (array_key_exists($keyRelative, $cacheArray)) {//merge
                        $merge                        = array_unique(array_merge($cacheArray[$keyRelative], $cacheArray[$key]));
                        $relativeToSelf[$keyRelative] = $merge;
                    }
                }
            }
        }

        return $this->mergeData($relativeToSelf, $selfToRelative);
    }

    /**
     * Returns a merged array
     * @param callable[] $words Array to merge
     * @return array
     */
    public function mergeData(array $words)
    {
        $args = func_get_args();
        //$args_num = func_num_args();
        $mergeArray = [];
        foreach ($args as $key => $value) {
            foreach ($value as $k => $v) {
                if (array_key_exists($k, $mergeArray)) {
                    $merge          = array_merge($mergeArray[$k], $value[$k]);
                    $mergeArray[$k] = array_unique($merge);
                } else {
                    $mergeArray[$k] = $v;
                }
            }
        }

        return $mergeArray;
    }

}