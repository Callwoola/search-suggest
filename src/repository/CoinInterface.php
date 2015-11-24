<?php

namespace Callwoola\SearchSuggest\repository;

/**
 * Interface CoinInterface
 * @package Callwoola\SearchSuggest\repository
 */
interface CoinInterface{


    /**
     * 设置 coin的 key
     *
     * @return mixed
     */
    public function setName();

    /**
     * 设置子数据
     *
     * @return mixed
     */
    public function setCoin();

}