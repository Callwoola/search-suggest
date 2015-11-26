<?php
namespace Callwoola\SearchSuggest\repository;

class Account
{
    protected $name   = '';
    protected $amount = [];
    protected $info   = [];
    protected $level  = 0;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param int $level
     */
    public function setLevel($level = 0)
    {
        $this->level = $level;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param array $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

}