<?php
namespace Callwoola\SearchSuggest\repository;

class Account
{
    protected $name   = '';
    protected $amount = [];
    protected $level  = 0;
    protected $inventories = [];

    public static function generate($accounts)
    {
        $generete = [];
        foreach($accounts as $name => $amount)
        {
            $generete[] = (new self)->setName($name)->setInventories($amount);
        }

        return $generete;
    }

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
     * @return self
     */
    public function setLevel($level = 0)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return array
     */
    public function getInventories()
    {
        return array_map(function($inentory){
            $inentory = explode('@', $inentory);
            return [
                'value' => $inentory[0],
                'info'  => unserialize($inentory[1])
            ];
        }, $this->inventories);
    }

    /**
     * @param array $inventories
     * @return self
     */
    public function setInventories($inventories)
    {
        $this->inventories = $inventories;

        return $this;
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
     * @param array $info
     */
    public function addAmount($amount, $info)
    {
        $this->amount[] = strtolower($amount) . '@' . serialize($info);
    }

}