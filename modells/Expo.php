<?php
class Expo {
    private $db_conn;
    public function __construct($db_conn) {
        $this->db_conn = $db_conn->getConnection();
    }

    public function create($name, $isActive, $location = null, $startsOn = null, $endsOn = null ) {
        $sql = "INSERT INTO expo (name, location, startsOn, endsOn, isActive) VALUES (:name, :location, :startsOn, :endsOn, :isActive)";
        $stmt = $this->db_conn->prepare($sql);
        
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':location', $location);
        $stmt->bindValue(':startsOn', $startsOn);
        $stmt->bindValue(':endsOn', $endsOn);
        $stmt->bindValue(':isActive', $isActive);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function get($id = null, $orderBy = null, $desc = false) {
        $allowedFields = ['name', 'location', 'startsOn', 'endsOn', 'isActive'];
        
        if (!in_array($orderBy, $allowedFields)) {
            return false;
        }

        if (is_null($id)) {
            $sql = "SELECT * FROM expo";

            if (!is_null($orderBy)) {
                $sql .= " ORDER BY " . $orderBy;
                if ($desc) {
                    $sql .= " DESC";
                }
            }
        } else {
            $sql = "SELECT * FROM expo WHERE id = '$id'";
        }
        
        $result = $this->db_conn->query($sql);
        $expos = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $expos[] = $row;
        }

        return $expos;
    }
    
    public function set($id, $field, $value) {
        $allowedFields = ['name', 'location', 'startsOn', 'endsOn', 'isActive'];
        
        if (!in_array($field, $allowedFields)) {
            return false;
        }

        $sql = "UPDATE expo SET $field = :value WHERE id = :id";
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
        $sql = "SELECT id FROM expo WHERE id = :id";
        $stmt = $this->db_conn->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        if ($stmt && $stmt->rowCount() > 0) {
            $deleteSql = "DELETE FROM expo WHERE id = :id";
            $deleteStmt = $this->db_conn->prepare($deleteSql);
            $deleteStmt->bindValue(':id', $id);
            $deleteStmt->execute();
            return true;
        }

        return false;
    }
}