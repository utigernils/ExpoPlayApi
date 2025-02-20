<?php
class Questions {
    private $db_conn;
    public function __construct($db_conn) {
        $this->db_conn = $db_conn->getConnection();
    }

    public function get($id = null, $orderBy = null, $desc = false) {
        $allowedFields = ['quiz', 'isActive', 'questionType', 'pointMultiplier', 'answerPossibilities'];
        
        if (!in_array($orderBy, $allowedFields)) {
            return false;
        }

        if (is_null($id)) {
            $sql = "SELECT * FROM questions";

            if (!is_null($orderBy)) {
                $sql .= " ORDER BY " . $orderBy;
                if ($desc) {
                    $sql .= " DESC";
                }
            }
        } else {
            $sql = "SELECT * FROM questions WHERE id = '$id'";
        }
        
        $result = $this->db_conn->query($sql);
        $questions = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $questions[] = $row;
        }

        return $questions;
    }

    public function set($id, $field, $value) {
        $allowedFields = ['quiz', 'isActive', 'questionType', 'pointMultiplier', 'answerPossibilities'];
        
        if (!in_array($field, $allowedFields)) {
            return false;
        }

        $sql = "UPDATE questions SET $field = :value WHERE id = :id";
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