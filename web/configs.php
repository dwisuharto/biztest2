<?php if (!defined("APP_PATH")) { die; }

return array(
    'webtitle' => 'FWork PHP Framework',
    'baseurl' => "http://" . $_SERVER['SERVER_NAME'],
    'viewDir' => APP_PATH . "/views",
    'namespace' => array(
        'controllers' => "App\\Controllers"
    )
);