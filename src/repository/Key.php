<?php

namespace Callwoola\SearchSuggest\repository;


use Callwoola\SearchSuggest\Suggest;
use Callwoola\SearchSuggest\Pinyin;
use Callwoola\SearchSuggest\StoreAdapter\RedisStore;

trait Key
{    
    /**
     * @var string
     */
    protected $word = '';

    /**
     * @return string
     */
    public function getKey()
    {
        $pinyin = Analyze::clear(Pinyin::getPinyin($this->word));
        $word = Analyze::clear($this->word);
        $word = preg_replace('/[^(\p{Han})|(\p{Latin})|(0-9)]/u', '', $word);

        return RedisStore::PREFIX . $this->getType() . '#' . $pinyin . '@' . $word;
    }

    /**
     * 生成搜索key
     *
     * @return string
     */
    public function getSearchKey($keyChain = [Suggest::KEY_RAW, Suggest::KEY_PINYIN])
    {
        $keys = [];

        // check have pinyin word
        if (Suggest::$config['cn_inlcude_pinyin'] != true) {
            $keyChain = [Suggest::KEY_RAW];
        }

        // generate keys for search
        foreach ($keyChain as $key)
        {
            if ($key == Suggest::KEY_RAW) {
                // raw char
                $word = Analyze::clear($this->word);

                $keys[] = (strlen($this->word) > 1)
                        ? RedisStore::PREFIX . $this->getType() . '#' . '*' . '@' . '*' . $word . '*'
                        : RedisStore::PREFIX . $this->getType() . '#' . '*' . '@' . $word . '*';            
            }

            if ($key == Suggest::KEY_PINYIN) {
                // pinyin
                $pinyin = Analyze::clear(Pinyin::getPinyin($this->word));

                $keys[] = (strlen($this->word) > 1)
                        ? RedisStore::PREFIX . $this->getType() . '#' . '*' . $pinyin . '*' . '@' . '*'
                        : RedisStore::PREFIX . $this->getType() . '#' . $pinyin . '*' . '@' . '*';
            }
        }

        return $keys;
    }
}