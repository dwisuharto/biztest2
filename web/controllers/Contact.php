<?php

namespace App\Controllers;

use FWork\Cores\Controller;

class Contact extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function defaultPath() {
        $cnt = array(
            'webtitle' => $this->configs['webtitle'],
            'baseurl' => $this->configs['baseurl']
        );
        $this->render("contact", $cnt);
    }

    public function submit() {
        $this->redirect($this->configs['baseurl']);
    }

}