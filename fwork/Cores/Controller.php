<?php

namespace FWork\Cores;

require_once "Mustache/Autoloader.php";

class Controller {

    private $mustache;
    protected $configs;
    public $request;

    function __construct() {
        \Mustache_Autoloader::register();
    }

    public function initViewEngine($configs = array()) {
        $this->configs = $configs;

        $this->mustache = new \Mustache_Engine(array(
            'template_class_prefix' => '__MyTemplates_',
            'cache' => dirname(__FILE__).'/tmp/cache/mustache',
            'cache_file_mode' => 0666,
            'cache_lambda_templates' => true,
            'loader' => new \Mustache_Loader_FilesystemLoader($this->configs['viewDir']),
            'partials_loader' => new \Mustache_Loader_FilesystemLoader($this->configs['viewDir'] . "/partials"),
            'helpers' => array('i18n' => function($text) {
                // do something translatey here...
            }),
            'escape' => function($value) {
                return htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
            },
            'charset' => 'ISO-8859-1',
            'logger' => new \Mustache_Logger_StreamLogger('php://stderr'),
            'strict_callables' => true,
            'pragmas' => [\Mustache_Engine::PRAGMA_FILTERS],
        ));
    }

    public function redirect($url = "") {
        header("Location: " . $url);
    }

    public function render($view = "", $cnt = array()) {
        $tpl = $this->mustache->loadTemplate($view);
        echo $tpl->render($cnt);
    }

}