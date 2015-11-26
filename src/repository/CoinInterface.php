<?php

namespace Callwoola\SearchSuggest\repository;

/**
 * Interface CoinInterface
 * @package Callwoola\SearchSuggest\repository
 */
interface CoinInterface
{
    /**
     * 设置 coin的 key
     *
     * @param string $name
     * @return mixed
     */
    public function setName($name);

    /**
     * 设置子数据
     *
     * @param max $value
     * @return mixed
     */
    public function setValue($value);

}