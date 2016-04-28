<?php
namespace Callwoola\SearchSuggest\repository;

class Account
{
    protected $name   = '';
    protected $amount = [];
    protected $level  = 0;
    protected $inventory = [];

    public static function generate($accounts)
    {
        $generete = [];

        foreach($accounts as $name => $amount)
        {
            $generete[] = (new self)->setName($name)->setInventory($amount);
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

    public function getRaw()
    {
        return $this->inventory;
    }

    /**
     * @return array
     */
    public function getInventory()
    {
        return unserialize($this->inventory);
    }

    /**
     * @return array
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param array $inventory
     * @return self
     */
    public function setInventory($inventory)
    {
        $this->inventory = $inventory;

        return $this;
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