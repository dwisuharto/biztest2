<?php if (!defined("APP_PATH")) { die; }

return array(
    'webtitle' => 'FWork PHP Framework',
    'baseurl' => "http://" . $_SERVER['SERVER_NAME'],
    'viewDir' => APP_PATH . "/views",
    'namespace' => array(
        'controllers' => array(
            'namespace' => "App\\Controllers",
            'dir' => APP_PATH . "/controllers"
        ),
        'models' => array(
            'namespace' => "App\\Models",
            'dir' => APP_PATH . "/models"
        )
    ),
    'database' => array(
        'db_host' => "localhost",
        'db_name' => "biztest",
        'db_uname' => "biztest",
        'db_paswd' => "biztest"
    )
);