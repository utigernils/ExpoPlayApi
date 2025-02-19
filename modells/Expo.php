<?php
class Expo {
    private $db_conn;
    public function __construct($db_conn) {
        $this->db_conn = $db_conn->getConnection();
    }
}