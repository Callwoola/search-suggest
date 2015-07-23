<?php

return [

    'key_type' => $_ENV['SEARCH_KEY_TYPE'], //固定值aliyun


    'elasticsearch' => [
        'url' => $_ENV['SEARCH_ELASTICSEARCH_URL'],
    ],

    'log' => $_ENV['SEARCH_LOG'],

    'high_light' => [
        'element_postfix' => $_ENV['SEARCH_HIGH_LIGHT_ELEMENT_POSTFIX'],
        'element_prefix' => $_ENV['SEARCH_HIGH_LIGHT_ELEMENT_PREFIX'],
    ],
];