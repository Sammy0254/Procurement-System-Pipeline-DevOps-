<?php
require_once(LIB_PATH_INC.DS."config.php");

class MySqli_DB {

    private $con;
    public $query_id;

    function __construct() {
        $this->db_connect();
    }

    /*--------------------------------------------------------------*/
    /* Function for Open database connection
    /*--------------------------------------------------------------*/
    public function db_connect() {
        $this->con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->con->connect_error) {
            die("Database connection failed: " . $this->con->connect_error);
        }
    }

    /*--------------------------------------------------------------*/
    /* Function for Close database connection
    /*--------------------------------------------------------------*/
    public function db_disconnect() {
        if (isset($this->con)) {
            $this->con->close();
            unset($this->con);
        }
    }

    /*--------------------------------------------------------------*/
    /* Function for mysqli query
    /*--------------------------------------------------------------*/
    public function query($sql) {
        if (trim($sql) != "") {
            $this->query_id = $this->con->query($sql);
        }
        if (!$this->query_id) {
            // Log the error for development mode
            error_log("Error on this Query: " . $sql . " - " . $this->con->error);
            // Display a user-friendly message
            die("Database query failed. Please contact support.");
        }
        return $this->query_id;
    }

    /*--------------------------------------------------------------*/
    /* Function for preparing statements
    /*--------------------------------------------------------------*/
    public function prepare($sql) {
        $stmt = $this->con->prepare($sql);
        if ($stmt === false) {
            // Log the error for development mode
            error_log("Error on this Prepare: " . $sql . " - " . $this->con->error);
            // Display a user-friendly message
            die("Database statement preparation failed. Please contact support.");
        }
        return $stmt;
    }

    /*--------------------------------------------------------------*/
    /* Function for Query Helper
    /*--------------------------------------------------------------*/
    public function fetch_array($statement) {
        return mysqli_fetch_array($statement);
    }

    public function fetch_object($statement) {
        return mysqli_fetch_object($statement);
    }

    public function fetch_assoc($statement) {
        return mysqli_fetch_assoc($statement);
    }

    public function num_rows($statement) {
        return mysqli_num_rows($statement);
    }

    public function insert_id() {
        return $this->con->insert_id;
    }

    public function affected_rows() {
        return $this->con->affected_rows;
    }

    /*--------------------------------------------------------------*/
    /* Function for Remove escapes special
    /* characters in a string for use in an SQL statement
    /*--------------------------------------------------------------*/
    public function escape($str) {
        return $this->con->real_escape_string($str);
    }

    /*--------------------------------------------------------------*/
    /* Function for while loop
    /*--------------------------------------------------------------*/
    public function while_loop($loop) {
        $results = array();
        while ($result = $this->fetch_array($loop)) {
            $results[] = $result;
        }
        return $results;
    }

}

$db = new MySqli_DB();
?>
