<?php

namespace FWork\Cores;

class Database {

    private $conn;
    private $result;

    function __construct($cfg = array()) {
        $this->conn = mysqli_connect($cfg['db_host'], $cfg['db_uname'], $cfg['db_paswd'], $cfg['db_name']);
    }

    public function query($sql = "") {
        $this->result = mysqli_query($this->conn, $sql);
    }

    public function execute($sql = "") {
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_execute($stmt);
    }

    public function nrow() {
        return mysqli_num_rows($this->result);
    }

    public function row() {
        return mysqli_fetch_assoc($this->result);
    }

    public function rows() {
        return mysqli_fetch_all($this->result, MYSQLI_ASSOC);
    }

    public function close() {
        mysqli_close($this->conn);
    }

}