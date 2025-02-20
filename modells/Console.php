<?php
class Console {
    private $db_conn;
    public function __construct($db_conn) {
        $this->db_conn = $db_conn->getConnection();
    }

    public function create($name, $location, $startsOn = null, $endsOn = null) {
        $name = $this->db_conn->real_escape_string($name);
        $location = $this->db_conn->real_escape_string($location);
        $startsOn = is_null($startsOn) ? "NULL" : "'" . $this->db_conn->real_escape_string($startsOn) . "'";
        $endsOn = is_null($endsOn) ? "NULL" : "'" . $this->db_conn->real_escape_string($endsOn) . "'";

        $sql = "INSERT INTO Console (name, location, startsOn, endsOn, isActive) 
                VALUES ('$name', '$location', $startsOn, $endsOn, 1)";

        if ($this->db_conn->query($sql)) {
            return $this->db_conn->insert_id;
        }
        return false;
    }

    public function get($id = null, $orderBy = null, $desc = false) {
        $allowedFields = ['currentExpo', 'currentQuiz', 'isActive'];
        
        if (!in_array($orderBy, $allowedFields)) {
            return false;
        }

        if (is_null($id)) {
            $sql = "SELECT * FROM console";

            if (!is_null($orderBy)) {
                $sql .= " ORDER BY " . $orderBy;
                if ($desc) {
                    $sql .= " DESC";
                }
            }
        } else {
            $sql = "SELECT * FROM console WHERE id = '$id'";
        }
        
        $result = $this->db_conn->query($sql);
        $consoles = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $consoles[] = $row;
        }

        return $consoles;
    }

    public function set($id, $field, $value) {
        $allowedFields = ['currentExpo', 'currentQuiz', 'isActive'];
        
        if (!in_array($field, $allowedFields)) {
            return false;
        }

        $sql = "UPDATE Console SET $field = :value WHERE id = :id";
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
        $sql = "SELECT id FROM Console WHERE id = '$id'";
        $result = $this->db_conn->query($sql);

        if ($result && $result->rowCount() > 0) {
            $deleteSql = "DELETE FROM Console WHERE id = '$id'";
            $this->db_conn->query($deleteSql);
            return true;
        }

        return false;
    }
}