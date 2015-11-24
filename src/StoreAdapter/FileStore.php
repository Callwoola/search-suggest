<?php

namespace Callwoola\SearchSuggest\StoreAdapter;


class FileStore implements StoreInterface
{

    private $path = '';

    private $name = '';

    private $value = [];


    public function __construct(){
//        $this->path = __DIR__ . '/../../temp';
    }

    public function store()
    {
        file_put_contents($this->name,serialize($this->value));
    }


    public function  find()
    {
        return null;
    }

    public function key($name = '')
    {
        $this->name = $name;
    }

    public function value($array = [])
    {
        $this->value = $array;
    }


}