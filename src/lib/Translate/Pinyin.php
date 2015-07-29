<?php


namespace Callwoola\Searchsuggest\lib\Translate;


/**
 * Class Pinyin
 * @package Callwoola\Search\lib\Translate
 */
class Pinyin
{

    /**
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
     * @var Object
     */
    protected static $instance;
    /**
     * @var array
     */
    protected static $pinyins;

    /**
     *  加载拼音词库
     */
    protected function __construct()
    {
        $pinyins = [];
        $loadFile = __DIR__ . '/dict/pinyin-utf8.dat';
        $loadExitFile = "./";
        //加到程序中可以static pinyins
        if (count($pinyins) == 0) {
            $fp = fopen($loadFile, 'r');
            while (!feof($fp)) {
                $line = trim(fgets($fp));
                if ($line) {
                    list($chinese, $pinyin) = explode('`', $line);
                    $pinyins[$chinese] = $pinyin;
                }
            }
            fclose($fp);
        }
        self::$pinyins = $pinyins;
        //return $pinyins;
    }

    /**
     * @param string $array
     */
    function fuzzySound($array = "")
    {

    }

    /**
     * 中文装成拼音
     * @return string
     */
    public function getPinyin($string = null, $isInitials = 0)
    {
        if (!isset(self::$PinyinString)) {
            $this->loadDict();
        }
        return $this->pinyin($string, $isInitials);

    }

    /**
     * 初始化配置
     */
    public static function init()
    {
        if (!self::$instance) {
            self::$instance = new self();
            return self::$instance;
        }
        return self::$instance;
    }


    /**
     *  加载词库
     *
     */
    private function loadDict()
    {

    }


    /**
     *  获取拼音信息
     *
     * @access    public
     * @param     string $str 字符串
     * @param     int $ishead 是否为首字母
     * @return    string
     */
    private function pinyin($str, $ishead = 0, $isdestroy = 1)
    {
        $restr = '';
        $pinyins = self::$pinyins;//$this->loadDict();
        $stringLen = strlen($str);
        if ($stringLen < 2) {
            return $str;
        }
        for ($i = 0; $i < $stringLen; $i++) {
            $cutString = substr($str, $i, 1);
            $ord = ord($cutString);
            if ($ord >= 224) {
                $cutString = substr($str, $i, 3);
                $i += 2;
            } elseif ($ord >= 192) {
                $cutString = substr($str, $i, 2);
                $i += 1;
            }
            if (isset($pinyins[$cutString])) {
                if ($ishead) {
                    $restr .= $pinyins[$cutString][0];
                } else {
                    $restr .= $pinyins[$cutString];
                }
            } elseif (preg_match("/[a-z0-9]/i", $cutString)) {
                $restr .= $cutString;
            }
        }
        if ($isdestroy) unset($pinyins);
        return $restr;
    }

    /**
     * 字符串转数组
     * @access    public
     * @param     string $str 字符串
     * @return    Array
     */
    public function stringToArray($string = null)
    {
        if ($string === null) return [];
        $stringArray = [];
        $stringLen = strlen($string);
        for ($i = 0; $i < $stringLen; $i++) {
            $cutString = substr($string, $i, 1);
            $ord = ord($cutString);
            if ($ord >= 224) {
                $cutString = substr($string, $i, 3);
                $i += 2;
            } elseif ($ord >= 192) {
                $cutString = substr($string, $i, 2);
                $i += 1;
            }

            $stringArray[] = $cutString;
        }
        return $stringArray;
    }

    /**
     *
     * @return Array
     */
    public static function make_semiangle($str)
    {
        $arr = array('０' => '0', '１' => '1', '２' => '2', '３' => '3', '４' => '4',
            '５' => '5', '６' => '6', '７' => '7', '８' => '8', '９' => '9',
            'Ａ' => 'A', 'Ｂ' => 'B', 'Ｃ' => 'C', 'Ｄ' => 'D', 'Ｅ' => 'E',
            'Ｆ' => 'F', 'Ｇ' => 'G', 'Ｈ' => 'H', 'Ｉ' => 'I', 'Ｊ' => 'J',
            'Ｋ' => 'K', 'Ｌ' => 'L', 'Ｍ' => 'M', 'Ｎ' => 'N', 'Ｏ' => 'O',
            'Ｐ' => 'P', 'Ｑ' => 'Q', 'Ｒ' => 'R', 'Ｓ' => 'S', 'Ｔ' => 'T',
            'Ｕ' => 'U', 'Ｖ' => 'V', 'Ｗ' => 'W', 'Ｘ' => 'X', 'Ｙ' => 'Y',
            'Ｚ' => 'Z', 'ａ' => 'a', 'ｂ' => 'b', 'ｃ' => 'c', 'ｄ' => 'd',
            'ｅ' => 'e', 'ｆ' => 'f', 'ｇ' => 'g', 'ｈ' => 'h', 'ｉ' => 'i',
            'ｊ' => 'j', 'ｋ' => 'k', 'ｌ' => 'l', 'ｍ' => 'm', 'ｎ' => 'n',
            'ｏ' => 'o', 'ｐ' => 'p', 'ｑ' => 'q', 'ｒ' => 'r', 'ｓ' => 's',
            'ｔ' => 't', 'ｕ' => 'u', 'ｖ' => 'v', 'ｗ' => 'w', 'ｘ' => 'x',
            'ｙ' => 'y', 'ｚ' => 'z',
            '（' => '(', '）' => ')', '〔' => '[', '〕' => ']', '【' => '[',
            '】' => ']', '〖' => '[', '〗' => ']', '“' => '[', '”' => ']',
            '‘' => '[', '’' => ']', '｛' => '{', '｝' => '}', '《' => '<',
            '》' => '>',
            '％' => '%', '＋' => '+', '—' => '-', '－' => '-', '～' => '-',
            '：' => ':', '。' => '.', '、' => ',', '，' => '.', '、' => '.',
            '；' => ',', '？' => '?', '！' => '!', '…' => '-', '‖' => '|',
            '”' => '"', '’' => '`', '‘' => '`', '｜' => '|', '〃' => '"',
            '　' => ' ','＄'=>'$','＠'=>'@','＃'=>'#','＾'=>'^','＆'=>'&','＊'=>'*',
            '＂'=>'"');

        return strtr($str, $arr);
    }

}