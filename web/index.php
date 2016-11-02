<?php

error_reporting(E_ALL);

define("APP_PATH", dirname(__FILE__));

require_once "../fwork/Singleton.php";

$configs = require "configs.php";
$singleton = new \FWork\Singleton($configs);

$singleton->init();

// define URL routing and binding controller name
$singleton->bind("/", "Home");
$singleton->bind("/contact", "Contact");

$singleton->run();
