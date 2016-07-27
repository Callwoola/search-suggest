<?php
namespace Callwoola\SearchSuggest;

use Exception;
use Callwoola\SearchSuggest\StoreAdapter\RedisStore;
use Callwoola\SearchSuggest\repository\Bank;
use Callwoola\SearchSuggest\repository\Coin;

/**
 * 搜索提示入口
 * @package Callwoola\SearchSuggest
 */
class Suggest
{
    const VERSION = '1.3.5';

    const KEY_RAW = 'raw';

    const KEY_PINYIN = 'pinyin';

    /**
     * @var Bank
     */
    protected $bank;

    /**
     * @var array
     */
    public static $config = [
        'cn_inlcude_pinyin' => true,
        'database' => null
    ];

    /**
     * Suggest constructor.
     *
     * @param $app
     * @param array $config
     */
    public function __construct($connect, $prepare = [])
    {
        if (!empty($prepare))
        {
            foreach (self::$config as $name => $value)
            {
                if (isset($prepare[$name])) {
                    self::$config[$name] = $prepare[$name];
                }
            }
        }

        // prepare redis conection
        if (isset(self::$config['database'])) {
            $connect->select(self::$config['database']);
        } else {
            $connect->select(RedisStore::DATABASE);
        }

        Pinyin::init();

        $this->bank = new Bank($connect);
    }

    /**
     * @param string $word
     * @param string $type
     * @return array
     */
    public function search($word, $type = '')
    {
        $bank     = $this->bank;
        $suggests = [];
        $results  = $bank->withdrawal($word ,$type);

        foreach ($results as $result) {
            $suggests[] = $result;
        }

        return $suggests;
    }

    /**
     * push a coin in suggest bank
     *
     * @param $coin
     * @throws Exception
     * @return bool
     */
    public function push($coin = [])
    {
        if (!isset($coin['name']) OR !isset($coin['data'])) {
            throw new Exception('Data parse error');
        }

        $coin = Coin::parse($coin);
        $bank = $this->bank;

        return $bank->deposit($coin);
    }


    /**
     * 清空数据库
     *
     * @return mixed|void
     */
    public function clear()
    {
        return $this->bank->robAll();
    }
}
