<?php

namespace Callwoola\SearchSuggest\StoreAdapter;

/**
 * Interface StoreInterface
 * @package Callwoola\SearchSuggest\StoreAdapter
 */
interface StoreInterface
{
    

    /**
     * @return mixed
     */
    public function store();

    /**
     * @return mixed
     */
    public function find();


    /**
     * @return mixed
     */
    public function key();


    /**
     * @return mixed
     */
    public function value();


}