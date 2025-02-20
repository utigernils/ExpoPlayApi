<?php
class Questions {
    private $db_conn;
    public function __construct($db_conn) {
        $this->db_conn = $db_conn->getConnection();
    }

    public function create($quiz, $isActive = true, $questionType, $pointMultiplier = null, $answerPossibilities = null) {
        $sql = "INSERT INTO questions (quiz, isActive, questionType, pointMultiplier, answerPossibilities) 
                VALUES (:quiz, :isActive, :questionType, :pointMultiplier, :answerPossibilities)";
        $stmt = $this->db_conn->prepare($sql);
        
        $stmt->bindValue(':quiz', $quiz);
        $stmt->bindValue(':isActive', $isActive);
        $stmt->bindValue(':questionType', $questionType);
        $stmt->bindValue(':pointMultiplier', $pointMultiplier);
        $stmt->bindValue(':answerPossibilities', $answerPossibilities);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
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

    public function delete($id) {
        $sql = "SELECT id FROM questions WHERE id = '$id'";
        $result = $this->db_conn->query($sql);

        if ($result && $result->rowCount() > 0) {
            $deleteSql = "DELETE FROM questions WHERE id = '$id'";
            $this->db_conn->query($deleteSql);
            return true;
        }

        return false;
    }
}