<?php
class DashboardUser {
    private $db_conn;
    public function __construct($db_conn) {
        $this->db_conn = $db_conn->getConnection();
    }

    public function get($id = null) {
        if (is_null($id)) {
            $sql = "SELECT * FROM dashboarduser";
        } else {
            $sql = "SELECT * FROM dashboarduser WHERE id = '$id'";
        }

        $result = $this->db_conn->query($sql);
        $users = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $users[] = $row;
        }

        return $users;
    }

    public function update($id, $updateData) {
        unset($updateData['id']);
        
        if (empty($updateData)) {
            return false;
        }

        $setParts = [];
        foreach ($updateData as $field => $value) {
            $setParts[] = "$field = :$field";
        }
        $setClause = implode(', ', $setParts);

        $sql = "UPDATE dashboarduser SET $setClause WHERE id = :id";
        $stmt = $this->db_conn->prepare($sql);
        
        $stmt->bindValue(':id', $id);
        
        foreach ($updateData as $field => $value) {
            $stmt->bindValue(":$field", $value);
        }

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
    public function create($data) {
        if (empty($data)) {
            return false;
        }

        $fields = array_keys($data);
        $values = array_fill(0, count($fields), '?');

        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_ARGON2I);
        }
        
        $sql = "INSERT INTO dashboarduser (" . implode(', ', $fields) . ") 
                VALUES (" . implode(', ', $values) . ")";
                
        try {
            $stmt = $this->db_conn->prepare($sql);
            $result = $stmt->execute(array_values($data));
            
            return $result;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete($id) {
        $sql = "DELETE FROM dashboarduser WHERE id = :id";
        $stmt = $this->db_conn->prepare($sql);
        $stmt->bindValue(':id', $id);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}