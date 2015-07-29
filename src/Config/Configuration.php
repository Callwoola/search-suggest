<?php


namespace Callwoola\Searchsuggest\Config;
/**
 * Class Configuration
 * @package Callwoola\Setup\Configurations
 */
trait Configuration
{

    /**
     * laravel version
     * @var string
     */


    public function getDatabaseConfig()
    {
        return [
            'driver' => 'mysql',
            'host' => $_ENV['DATABASE.HOST'],
            'database' => $_ENV['DATABASE.DATABASE'],
            'username' => $_ENV['DATABASE.USERNAME'],
            'password' => $_ENV['DATABASE.PASSWORD'],
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ];
    }

    public function getRedisConfig()
    {
        return [
            'host' => $_ENV['REDIS_DEFAULT_HOST'],
            'port' => $_ENV['REDIS_DEFAULT_PORT'],
            'database' => '1',
        ];

    }


    public function getElasticsearchConfig()
    {
        return [
            "url" => $_ENV['SEARCH_ELASTICSEARCH_URL'],
        ];
    }

    public function getHighLightConfig()
    {

        return [
            "element_postfix" => $_ENV['SEARCH_HIGH_LIGHT_ELEMENT_POSTFIX'],
            "element_prefix" => $_ENV['SEARCH_HIGH_LIGHT_ELEMENT_PREFIX'],
        ];

    }
}