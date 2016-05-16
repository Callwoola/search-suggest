<?php

namespace Callwoola\SearchSuggest\StoreAdapter;

use Callwoola\SearchSuggest\repository\Cheque;
use Callwoola\SearchSuggest\repository\Coin;

/**
 * Interface StoreInterface
 * @package Callwoola\SearchSuggest\StoreAdapter
 */
interface StoreInterface
{
    /**
     * @param Coin $coin
     * @return mixed
     */
    public function store(Coin $coin);


    /**
     * @param Cheque $cheque
     * @return mixed
     */
    public function find(Cheque $cheque);

    /**
     * @param string $name
     * @return mixed
     */
    public function setKey($name);


    /**
     * @param string $value
     * @return mixed
     */
    public function setValue($value);


    /**
     * @return mixed
     */
    public function clear();
}