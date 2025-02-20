<?php
class Quiz {
    private $db_conn;
    public function __construct($db_conn) {
        $this->db_conn = $db_conn->getConnection();
    }

    public function set($id, $field, $value) {
        $allowedFields = ['name', 'isActive'];
        
        if (!in_array($field, $allowedFields)) {
            return false;
        }

        $sql = "UPDATE quiz SET $field = :value WHERE id = :id";
        $stmt = $this->db_conn->prepare($sql);
        
        $stmt->bindValue(':value', $value);
        $stmt->bindValue(':id', $id);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}