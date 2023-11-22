<?php
date_default_timezone_set("Asia/Yangon");

class database {
    private $database;
    private $stm;

    public function __construct() {
        try {
            $this->database = new PDO("mysql: host=localhost; port=3601; dbname=greenhil_maindb; 
            charset=UTF8", "greenhil_admin", "56q8fO+VDL:or7");
            $this->database->setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
            $this->database->setAttribute(PDO:: ATTR_DEFAULT_FETCH_MODE, PDO:: FETCH_OBJ);
        }
        catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function query($query) {
        $this->stm = $this->database->prepare($query);
    }

    public function bind($params, $value) {
        $this->stm->bindParam($params, $value);
    }

    public function execute() {
        return $this->stm->execute();
    }

    public function resultset() {
        $this->execute();
        return $this->stm->fetchAll(PDO::FETCH_OBJ);
    }

    public function resultset_array() {
        $this->execute();
        return $this->stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function row_count() {
        $this->execute();
        return $this->stm->rowCount();
    }
}

//comment the two lines for production
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
?>