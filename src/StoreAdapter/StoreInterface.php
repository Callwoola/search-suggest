<?php

namespace Callwoola\SearchSuggest\StoreAdapter;

/**
 * Interface StoreInterface
 * @package Callwoola\SearchSuggest\StoreAdapter
 */
interface StoreInterface
{
    /**
     * @param string $key
     * @param string $value
     * @return mixed
     */
    public function store($key,$value);


    /**
     * @param string $name
     * @return mixed
     */
    public function find($name);

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