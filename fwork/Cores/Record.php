<?php

namespace FWork\Cores;

abstract class Record {

    protected $db;
    public $isNewByCreate = false;

    function __construct() {
    }

    public static function create($db, $data = array()) {
        $className = get_called_class();
        $newObj = new $className($db, $data);
        $newObj->isNewByCreate = true;

        if (is_array($data) && count($data) > 0) {
            foreach ($data as $key => $value) {
                $newObj->$key = $value;
            }
        }

        return $newObj;
    }

    public function save() {
        $objProps = get_object_vars($this);
        $fieldId = key($objProps);

        $classNames = explode("\\", strtolower(get_class($this)));
        $tableName = array_pop($classNames);
        if ($this->isNewByCreate) {
            $sql = "INSERT INTO " . $tableName . " (";

            $sql_ar = array();
            foreach ($this as $key => $value) {
                if ($key != "db" && $key != "isNewByCreate" && $key != $fieldId) {
                    $sql_ar[] = "`" . $key . "`";
                    $sql_ar[] = ",";
                }
            }
            array_pop($sql_ar);
            $sql .= implode("", $sql_ar) . ") VALUES (";

            $sql_ar = array();
            foreach ($this as $key => $value) {
                if ($key != "db" && $key != "isNewByCreate" && $key != $fieldId) {
                    if (is_string($value)) {
                        $sql_ar[] = "'" . $value . "'";
                    } else if (is_int($value) || is_float($value)) {
                        $sql_ar[] = $value;
                    }
                    $sql_ar[] = ",";
                }
            }
            array_pop($sql_ar);
            $sql .= implode("", $sql_ar) . ")";
        } else {
            $sql = "UPDATE " . $tableName . " SET ";

            $sql_ar = array();
            foreach ($this as $key => $value) {
                if ($key != "db" && $key != "isNewByCreate" && $key != $fieldId) {
                    $sql_ar[] = "`" . $key . "` = ";

                    if (is_string($value)) {
                        $sql_ar[] = "'" . $value . "'";
                    } else if (is_int($value) || is_float($value)) {
                        $sql_ar[] = $value;
                    }
                    $sql_ar[] = ",";
                }
            }
            array_pop($sql_ar);
            $sql .= implode("", $sql_ar) . " WHERE " . $fieldId . " = ";
            if (is_string($this->$fieldId)) {
                $sql .= "'" . $this->$fieldId . "'";
            } else if (is_int($this->$fieldId) || is_float($this->$fieldId)) {
                $sql .= $this->$fieldId;
            }
        }
        var_dump($sql);
        $this->db->execute($sql);
    }

    public static function get_all($db) {
        $className = get_called_class();
        $classNames = explode("\\", strtolower($className));
        $tableName = array_pop($classNames);

        $db->query("SELECT * FROM " . $tableName);
        return $db->rows();
    }

    public static function get_one($db, $id) {
        $className = get_called_class();
        $objTemp = new $className($db);
        $objProps = get_object_vars($objTemp);
        $fieldId = key($objProps);
        $classNames = explode("\\", strtolower($className));
        $tableName = array_pop($classNames);

        $db->query("SELECT * FROM " . $tableName . " WHERE " . $fieldId . " = " . $id);
        $row = $db->row();
        $objTemp->id = $row['id'];
        $objTemp->name = $row['name'];
        $objTemp->email = $row['email'];
        $objTemp->msg = $row['msg'];

        return $objTemp;
    }

    public function delete() {
        $objProps = get_object_vars($this);
        $fieldId = key($objProps);

        $classNames = explode("\\", strtolower(get_class($this)));
        $tableName = array_pop($classNames);

        if (!is_null($this->$fieldId) && !empty($this->$fieldId)) {
            $this->db->execute("DELETE FROM " . $tableName . " WHERE " . $fieldId . " = " . $this->$fieldId);
        }
    }

}