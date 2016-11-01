<?php

namespace App\Controllers;

use FWork\Cores\Controller;

class Home extends Controller {

    function __construct() {
        parent::__construct();
    }

    /*
     * this is a default function to be called related to pre-defined route
     */
    public function index() {
        $cnt = array(
            'webtitle' => $this->configs['webtitle'],
            'baseurl' => $this->configs['baseurl']
        );
        $this->render("home", $cnt);
    }

}