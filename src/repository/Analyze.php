<?php

namespace Callwoola\SearchSuggest\repository;

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
        $split     = new Split();
        $strings   = $split->start($string);
        $strings[] = $string;
        // TODO 过滤
        return self::generate($strings);
    }

    /**
     * ...
     *
     * @param $strings
     * @return array
     */
    public static function generate($strings)
    {
        $generates = [];
        foreach ($strings as $string) {
            $account = new Account();
            $account->setName(Pinyin::getPinyin($string));
            $account->setAmount($string);
            $generates[] = $account;

            $account = new Account();
            $account->setName(Pinyin::getPinyinFirst($string));
            $account->setAmount($string);
            $generates[] = $account;

            $account = new Account();
            $account->setName($string);
            $account->setAmount($string);
            $generates[] = $account;
        }

        return $generates;
    }

    /**
     * 得到所有数据分词后的数组
     * @return array
     */
    public function getAnalyzeDict()
    {

        return [Pinyin::getPinyin('你好')];
        //        //get all title
        //        $dataManage = new DataManage();
        //        $goodsData = $dataManage->getAllTitle();
        //        $dicts = [];
        //        foreach ($goodsData as $key => $value) {
        //            $words = $this->getAnalyze($value['title'] . $value['subtitle'] . $value['attribute_name']);
        //            foreach ($words as $name) {
        //                //echo $value['title'];exit();
        //                $match = '/^[a-z|0-9]/';
        //                if (!preg_match($match, $name)) {
        //                    $dicts[] = $name;
        //                }
        //            }
        //        }
        //        return array_unique($dicts);
    }

    /**
     * 缓存声母 索引 可开启每个字声母索引
     * @param int $isAll
     * @param array $dict
     * @return array $cacheArray
     */
    public function getCacheInitials($isAll = 0, $dict = null)
    {
        if ($dict === null) {
            $dict = $this->getAnalyzeDict();
        }
        //get First Letter
        // 1 letter 2 letter and 3 letter maybe more letter  stored in redis
        $cacheArray = [];
        //$pinyin = new Pinyin();
        $pinyin = Pinyin::init();
        foreach ($dict as $k => $v) {
            $key                = $pinyin->getPinyin($v, 1);
            $cacheArray[$key][] = $v;
        }
        //add more Initials
        //$isAll=1;
        foreach ($cacheArray as $key => $words) {
            if (strlen($key) > 1) {
                if ($isAll == 1) {
                    foreach (range(0, strlen($key) - 1) as $num) {
                        if (array_key_exists($key[$num], $cacheArray)) {
                            // merge Initials and Initials word into exit single initial
                            $merge                  = array_merge($cacheArray[$key], $cacheArray[$key[$num]]);
                            $cacheArray[$key[$num]] = array_unique($merge);
                        } else {
                            $cacheArray[$key[$num]] = $cacheArray[$key];
                        }
                    }
                } else {
                    if (array_key_exists($key[0], $cacheArray)) {
                        // merge Initials and Initials word into exit single initial
                        $merge               = array_merge($cacheArray[$key], $cacheArray[$key[0]]);
                        $cacheArray[$key[0]] = array_unique($merge);
                    } else {
                        $cacheArray[$key[0]] = $cacheArray[$key];
                    }
                }
            }
        }

        return $cacheArray;
    }

    /**
     * 缓存全拼 索引 可开启每个字全拼索引
     * @param string $word
     * @param int $isAll
     * @return array $cacheArray
     */
    public function getCachePinyin($isAll = 0, $dict = null)
    {
        if ($dict === null) {
            $dict = $this->getAnalyzeDict();
        }
        $cacheArray = [];
        $pinyin     = Pinyin::init();
        if ($isAll == 1) {
            //每个字的全拼
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
            //首个字的全拼
            foreach ($dict as $v) {
                $stringArray        = $pinyin->stringToArray($v);
                $key                = $pinyin->getPinyin($stringArray[0]);
                $cacheArray[$key][] = $v;
            }
        }

        return $cacheArray;
    }

    /**
     * 缓存全拼的 模糊音
     * @param string $word
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
     * 缓存 中文
     * @return array $cacheArray
     */
    public function getCacheChinese()
    {
        $dataManage  = new DataManage();
        $goodsData   = $dataManage->getGoodsRecord();
        $chineseList = [];
        // get all chinese string
        foreach ($goodsData as $k => $v) {
            $v           = (object)$v;
            $search      = $v->title . $v->subtitle . $v->attribute_name;
            $chineseList = array_unique(array_merge($this->getAnalyze($search), $chineseList));
        }

        //filter item
        $filterList = [];
        foreach ($chineseList as $v) {
            if (!preg_match("/[a-z|A-Z|0-9|\\s]+/i", $v)) {
                if (count(Pinyin::init()->stringToArray($v)) >= 2) {
                    $filterList[] = $v;
                }
            }
        }

        return $filterList;
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