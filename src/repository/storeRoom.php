<?php

namespace Callwoola\SearchSuggest\repository;

class storeRoom{

    private static $instance =null ;

    private function __construct(){

    }

    public static function instance()
    {

        if (self::$instance) {


            self::$instance = new storeRoom();
            return self::$instance;
        }else{
            return self::$instance;
        }
    }


    public function hit(){

    }

    public function clear($key){
        
    }
}