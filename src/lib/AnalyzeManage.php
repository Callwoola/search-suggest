<?php

namespace Callwoola\SearchSuggest\lib;


use Callwoola\SearchSuggest\lib\Translate\Pinyin;
use Callwoola\SearchSuggest\Config\Configuration;

use Callwoola\SearchSuggest\analysis\ChineseAnalysis;
/**
 * 通过ik 词库 进行分词，同时检查Callwoola.dat 是否有特定的分词条件
 *
 */
class AnalyzeManage
{
    use Configuration;
    public $arr=[];

    /**
     * @param string $str
     * @return array
     */
    public  function getChineseAnalysis($str=''){
        if($str==''){
            return [];
        }
        ChineseAnalysis::$loadInit = false;
        $pa = new ChineseAnalysis('utf-8', 'utf-8', false);
        $pa->LoadDict();
        $pa->SetSource($str);
        $pa->differMax = false;
        $pa->unitWord = false;
        $pa->StartAnalysis(true);

        $getInfo=true;
        $sign='-';
        $result=$pa->GetFinallyResult($sign,$getInfo);
        $result=explode($sign,$result);
        $filterResult=[];

        // do not use GetFinallIndex I don`t need unknow info
//        $resultArray=$pa->GetFinallyIndex();

        // simple filter just allow noun
        foreach($result as $k=>$value){
            if (preg_match('/\/n/i', $value) === 1) {
                $arrValue=explode('/',$value);
                $filterResult[$arrValue[0]]=(int)preg_replace('/(n[a-z|A-Z]*)/','',$arrValue[1]);
            }
        }

        return $filterResult;
    }


    /**
     * @param array $arr
     */
    public function setDictArr($arr=[]){
        $this->arr=$arr;
    }
    /**
     * 得到所有数据分词后的数组
     * @return array
     */
    public function getAnalyzeDict()
    {
        if(!count($this->arr)>0){
            return false;
        }
        $arrlist=$this->arr;
        $dicts = [];
        foreach ($arrlist as $key => $value) {
            $words = $this->getChineseAnalysis($value);

            foreach ($words as $k_name=> $num) {
                $k_name=Pinyin::make_semiangle($k_name);
                $k_name=preg_replace("/([[:alnum:]]|[[:space:]]|[[:punct:]])+/U", '', $k_name);
                $match = '/^[a-z|A-Z|0-9]/';
                if (!preg_match($match, $k_name) and !empty($k_name)) {
                    $dicts[] = $k_name;
                }
            }
        }
        return array_unique($dicts);
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
            $key = $pinyin->getPinyin($v, 1);
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
                            $merge = array_merge($cacheArray[$key], $cacheArray[$key[$num]]);
                            $cacheArray[$key[$num]] = array_unique($merge);
                        } else {
                            $cacheArray[$key[$num]] = $cacheArray[$key];
                        }
                    }
                } else {
                    if (array_key_exists($key[0], $cacheArray)) {
                        // merge Initials and Initials word into exit single initial
                        $merge = array_merge($cacheArray[$key], $cacheArray[$key[0]]);
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
        $pinyin = Pinyin::init();
        if ($isAll == 1) {
            //每个字的全拼
            foreach ($dict as $words) {
                $stringArray = $pinyin->stringToArray($words);
                $linkpinyin='';
                foreach ($stringArray as $k => $word) {
                    $tranPinyin = $pinyin->getPinyin($word);
                    $linkpinyin=$linkpinyin.$tranPinyin;
                    $cacheArray[$linkpinyin][] = $words;
                    if($k>0){
                        $cacheArray[$linkpinyin][] = $words;
                    }
                }
            }
        } else {
            //首个字的全拼
            foreach ($dict as $v) {
                $stringArray = $pinyin->stringToArray($v);
                $key = $pinyin->getPinyin($stringArray[0]);
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
        $cacheArray = $this->getCacheInitials($isAll);
        $pinyin = Pinyin::init();
        if ($dict === null) {
            $dict = $this->getAnalyzeDict();
        }

        if ($isAll == 1) {
            //each word
            foreach ($dict as $words) {
                $stringArray = $pinyin->stringToArray($words);
                $linkpinyin='';
                foreach ($stringArray as $k => $word) {
                    $tranPinyin = $pinyin->getPinyin($word);
                    $linkpinyin=$linkpinyin.$tranPinyin;
                    $cacheArray[$linkpinyin][] = $words;
                    if($k>0){
                        $cacheArray[$linkpinyin][] = $words;
                    }
                }
            }
        } else {
            //first word
            foreach ($dict as $v) {
                $stringArray = $pinyin->stringToArray($v);
                $key = $pinyin->getPinyin($stringArray[0]);
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
                        $merge = array_unique(array_merge($cacheArray[$keyRelative], $cacheArray[$key]));
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
                        $merge = array_unique(array_merge($cacheArray[$keyRelative], $cacheArray[$key]));
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
                        $merge = array_unique(array_merge($cacheArray[$keyRelative], $cacheArray[$key]));
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
                        $merge = array_unique(array_merge($cacheArray[$keyRelative], $cacheArray[$key]));
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
        $dictList=$this->getAnalyzeDict();
        // get all chinese string
        // for what ?
        // 现在 是直接通过 keys 储存 也就是说 keys
        $filterList=[];
        foreach ($dictList as $v) {
            if(!preg_match("/[a-z|A-Z|0-9|\\s]+/i",$v)){
                if(count(Pinyin::init()->stringToArray($v))>=2){
                    $filterList[]=$v;
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
                    $merge = array_merge($mergeArray[$k], $value[$k]);
                    $mergeArray[$k] = array_unique($merge);
                } else {
                    $mergeArray[$k] = $v;
                }
            }
        }
        return $mergeArray;
    }

}