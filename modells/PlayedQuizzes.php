<?php
class PlayedQuizzes {
    private $db_conn;
    public function __construct($db_conn) {
        $this->db_conn = $db_conn->getConnection();
    }

    public function create($player, $quiz, $startedOn, $quizName, $expo = null, $endedOn = null, $correctAnswers = null, $wrongAnswers = null, $expoName = null) {
        $sql = "INSERT INTO playedquizzes (player, quiz, expo, startedOn, endedOn, correctAnswers, wrongAnswers, quizName, expoName) 
                VALUES (:player, :quiz, :expo, :startedOn, :endedOn, :correctAnswers, :wrongAnswers, :quizName, :expoName)";
        $stmt = $this->db_conn->prepare($sql);
        
        $stmt->bindValue(':player', $player);
        $stmt->bindValue(':quiz', $quiz);
        $stmt->bindValue(':expo', $expo);
        $stmt->bindValue(':startedOn', $startedOn);
        $stmt->bindValue(':endedOn', $endedOn);
        $stmt->bindValue(':correctAnswers', $correctAnswers);
        $stmt->bindValue(':wrongAnswers', $wrongAnswers);
        $stmt->bindValue(':quizName', $quizName);
        $stmt->bindValue(':expoName', $expoName);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function get($id = null, $orderBy = null, $desc = false) {
        $allowedFields = ['player', 'quiz', 'expo', 'startedOn', 'endedOn', 'correctAnswers', 'wrongAnswers', 'quizName', 'expoName', null];
        
        if (!in_array($orderBy, $allowedFields)) {
            return false;
        }

        if (is_null($id)) {
            $sql = "SELECT * FROM playedquizzes";

            if (!is_null($orderBy)) {
                $sql .= " ORDER BY " . $orderBy;
                if ($desc) {
                    $sql .= " DESC";
                }
            }
        } else {
            $sql = "SELECT * FROM playedquizzes WHERE id = '$id'";
        }
        
        $result = $this->db_conn->query($sql);
        $playedquizzes = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $playedquizzes[] = $row;
        }

        return $playedquizzes;
    }

    public function set($id, $field, $value) {
        $allowedFields = ['player', 'quiz', 'expo', 'startedOn', 'endedOn', 'correctAnswers', 'wrongAnswers', 'quizName', 'expoName', null];
        
        if (!in_array($field, $allowedFields)) {
            return false;
        }

        $sql = "UPDATE playedquizzes SET $field = :value WHERE id = :id";
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
        $sql = "SELECT id FROM playedquizzes WHERE id = :id";
        $stmt = $this->db_conn->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        if ($stmt && $stmt->rowCount() > 0) {
            $deleteSql = "DELETE FROM playedquizzes WHERE id = :id";
            $deleteStmt = $this->db_conn->prepare($deleteSql);
            $deleteStmt->bindValue(':id', $id);
            $deleteStmt->execute();
            return true;
        }

        return false;
    }
}