<?php

namespace Callwoola\SearchSuggest\repository;

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
    public function getSearchKey()
    {
        $pinyin = Analyze::clear(Pinyin::getPinyin($this->word));
        $word = Analyze::clear($this->word);

        $keys = [];

        // raw char
        $keys[] = (strlen($this->word) > 1)
            ? RedisStore::PREFIX . $this->getType() . '#' . '*' . '@' . '*' . $word . '*'
            : RedisStore::PREFIX . $this->getType() . '#' . '*' . '@' . $word . '*';

        // pinyin
        $keys[] = (strlen($this->word) > 1)
            ? RedisStore::PREFIX . $this->getType() . '#' . '*' . $pinyin . '*' . '@' . '*'
            : RedisStore::PREFIX . $this->getType() . '#' . $pinyin . '*' . '@' . '*';

        return $keys;
    }
}