<?php
/**
 * MySQLi Database Class
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class MySqlii {

    /**
     * @var int
     */
    private $queryCount = 0;

    /**
     * @var mysqli
     */
    private $conn;

    /**
     * @var mysqli_result
     */
    private $result;

    /**
     * @var object MySql
     */
    private static $instance;

    private function __construct() {
        if (!class_exists('mysqli')) {
            emMsg(lang('mysqli_not_supported'));
        }

        mysqli_report(MYSQLI_REPORT_ERROR);

        @$this->conn = new mysqli(DB_HOST, DB_USER, DB_PASSWD, DB_NAME);
        if ($this->conn->connect_error) {
            switch ($this->conn->connect_errno) {
                case 1044:
                case 1045:
                    emMsg(lang('db_credential_error'));
                    break;
                case 1049:
                    emMsg(lang('db_not_found'));
                    break;
                case 2003:
                case 2005:
                case 2006:
                    emMsg(lang('db_unavailable'));
                    break;
                default :
                    emMsg(lang('db_error_code') . $this->conn->connect_error);
                    break;
            }
        }

        $this->conn->set_charset('utf8mb4');
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new MySqlii();
        }

        return self::$instance;
    }

    public function close() {
        return $this->conn->close();
    }

    public function query($sql, $ignore_err = FALSE) {
        $this->result = $this->conn->query($sql);
        $this->queryCount++;
        if (!$ignore_err && 1046 == $this->getErrNo()) {
            emMsg(lang('db_error_name'));
        }
        if (!$ignore_err && 1115 == $this->getErrNo()) {
            emMsg(lang('utf8mb4_not_support'));
        }
        if (!$ignore_err && !$this->result) {
            emMsg("$sql<br /><br />error: " . $this->getErrNo() . ' , ' . $this->getError());
        } else {
            return $this->result;
        }
    }

    public function fetch_array(mysqli_result $query, $type = MYSQLI_ASSOC) {
        return $query->fetch_array($type);
    }

    public function fetch_all($sql, $fetchMode = MYSQLI_ASSOC) {
        $this->result = $this->query($sql);
        $data = [];
        while ($row = $this->fetch_array($this->result, $fetchMode)) {
            $data[] = $row;
        }
        return $data;
    }

    public function once_fetch_array($sql) {
        $this->result = $this->query($sql);
        return $this->fetch_array($this->result);
    }

    public function fetch_row(mysqli_result $query) {
        return $query->fetch_row();
    }

    public function num_rows(mysqli_result $query) {
        return $query->num_rows;
    }

    public function num_fields(mysqli_result $query) {
        return $query->field_count;
    }

    public function insert_id() {
        return $this->conn->insert_id;
    }

    /**
     * Get mysql error
     */
    public function getError() {
        return $this->conn->error;
    }

    /**
     * Get mysql error code
     */
    public function getErrNo() {
        return $this->conn->errno;
    }

    /**
     * Get number of affected rows in previous MySQL operation
     */
    public function affected_rows() {
        return $this->conn->affected_rows;
    }

    public function getVersion() {
        return $this->conn->server_info;
    }

    public function getQueryCount() {
        return $this->queryCount;
    }

    /**
     *  Escapes special characters
     */
    public function escape_string($sql) {
        return $this->conn->real_escape_string($sql);
    }

    public function listTables() {
        $rs = $this->query(sprintf("SHOW TABLES FROM `%s`", DB_NAME));
        $tables = [];
        while ($row = $this->fetch_row($rs)) {
            $tables[] = isset($row[0]) ? $row[0] : '';
        }
        return $tables;
    }

}
