<?php

error_reporting(E_ALL);

define("APP_PATH", dirname(__FILE__));

require_once "../fwork/Singleton.php";
use FWork\Singleton;

require_once "controllers/Home.php";
require_once "controllers/Contact.php";

$configs = require "configs.php";
$singleton = new Singleton($configs);

$singleton->init();

$singleton->bind("/", "Home");
$singleton->bind("/contact", "Contact");

$singleton->run();
