<?php

namespace Callwoola\SearchSuggest\StoreAdapter;


use UnexpectedValueException as BaseUnexpectedValueException;


/**
 * 储存错误
 *
 * Class CanNotStoreException
 * @package Callwoola\SearchSuggest\StoreAdapter
 */
class CanNotStoreException extends BaseUnexpectedValueException implements ExceptionInterface
{
    const CANNOT_STORE = 10001;

    public function __construct()
    {
        parent::__construct('Can not store value' , self::CANNOT_STORE);
    }
}