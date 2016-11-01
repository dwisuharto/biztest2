<?php

namespace App\Models;

use FWork\Cores\Record;

class Contact extends Record {

    public $id;
    public $name;
    public $email;
    public $msg;

    function __construct($db = null) {
        $this->db = $db;
    }

}