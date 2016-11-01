<?php

namespace FWork;

require_once "Cores/Controller.php";
require_once "Cores/Database.php";
require_once "Cores/Record.php";

use FWork\Cores\Database;

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

    public function init() {
        foreach ($this->configs['namespace'] as $key => $namespace) {
            foreach (scandir($namespace['dir']) as $file) {
                if ('.' === $file) continue;
                if ('..' === $file) continue;

                require_once $namespace['dir'] . "/" . $file;
            }
        }
    }

    public function bind($route = "", $handler = "") {
        $handler = $this->configs['namespace']['controllers']['namespace'] . "\\" . $handler;
        $routeHandler = new $handler();
        $routeHandler->initViewEngine($this->configs);
        $this->listRoutes[$route] = $routeHandler;
    }

    public function run() {
        $routeHandler = null;
        $routeLevel = 0;

        $params = array();
        $action = "";
        if (preg_match("/^\\/[a-zA-Z0-9]{0,}$/", $this->request_uri) > 0) {
            if (isset($this->listRoutes[$this->request_uri])) {
                $routeHandler = $this->listRoutes[$this->request_uri];
                $routeLevel = 1;
            } else {
                $this->_404();
            }
        } else {
            $uris = explode("/", $this->request_uri);
            $action = $uris[2];
            for ($i = 3; $i < count($uris); $i++) {
                $params[] = $uris[$i];
            }
            $routeHandler = $this->listRoutes["/" . $uris[1]];
            $routeLevel = 2;
        }

        $routeHandler->request = (object) array();
        $routeHandler->request->params = $_REQUEST;
        $routeHandler->db = new Database($this->configs['database']);

        if ($routeLevel > 0) {
            if ($routeLevel == 1) {
                $routeHandler->index();
            } else if ($routeLevel == 2) {
                $routeHandler->$action(...$params);
            }
        }
    }

    private function _404() {
        echo "404";
    }

}