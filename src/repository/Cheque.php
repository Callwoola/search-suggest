<?php
namespace Callwoola\SearchSuggest\repository;



/**
 * Class Cheque
 * @package Callwoola\SearchSuggest\repository
 */
class Cheque
{
    use Key;

    protected $key;
    protected $rawName = '';
    protected $type = '';

    /**
     * Cheque constructor.
     * @param $word
     * @param $type
     */
    public function __construct($word, $type)
    {
        $this->word = $word;

        $this->setKey($word);
        $this->setRawName($word);
        $this->setType($type);
    }


    /**
     * @param $word
     * @param $type
     * @return Cheque
     */
    public static function parse($word, $type)
    {
        return new self($word, $type);
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param mixed $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getRawName()
    {
        return $this->rawName;
    }

    /**
     * @param string $rawName
     */
    public function setRawName($rawName)
    {
        $this->rawName = $rawName;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

}