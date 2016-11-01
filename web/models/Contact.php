<?php

namespace App\Models;

use FWork\Cores\Record;

class Contact extends Record {

    public $id;
    public $name;
    public $email;
    public $msg;

    function __construct($db = null, $data = array()) {
        $this->db = $db;

        if (is_array($data) && count($data) > 0) {
            foreach ($data as $key => $value) {
                $this->$key = $value;
            }
        }
    }

}