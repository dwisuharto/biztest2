<?php

namespace FWork;

require_once "Cores/Controller.php";

use App\Controllers\Home;

class Singleton {

    private $configs;
    private $request_uri;
    private $request_method;
    private $listRoutes = array();

    function __construct($configs = null) {
        if (!is_null($configs)) {
            $this->configs = $configs;
        }

        $this->request_uri = $_SERVER['REQUEST_URI'];
        $this->request_method = $_SERVER['REQUEST_METHOD'];
    }

    public function bind($route = "", $handler = "") {
        $handler = $this->configs['namespace']['controllers'] . "\\" . $handler;
        $routeHandler = new $handler();
        $routeHandler->initViewEngine($this->configs);
        $this->listRoutes[$route] = $routeHandler;
    }

    public function run() {
        if (preg_match("/^\\/[a-zA-Z0-9]{0,}$/", $this->request_uri) > 0) {
            if (isset($this->listRoutes[$this->request_uri])) {
                $this->listRoutes[$this->request_uri]->defaultPath();
            } else {
                $this->_404();
            }
        } else {
            $uris = explode("/", $this->request_uri);
            $action = $uris[2];
            $this->listRoutes["/" . $uris[1]]->$action();
        }
    }

    private function _404() {
        echo "404";
    }

}