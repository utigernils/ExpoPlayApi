<?php
class DashboardUser {
    private $db_conn;
    public function __construct($db_conn) {
        $this->db_conn = $db_conn->getConnection();
    }

    public function create($firstName, $lastName, $email, $password, $isAdmin = false) {
        $sql = "INSERT INTO dashboarduser (firstName, lastName, email, password, isAdmin) VALUES (:firstName, :lastName, :email, :password, :isAdmin)";
        $stmt = $this->db_conn->prepare($sql);
        
        $stmt->bindValue(':firstName', $firstName);
        $stmt->bindValue(':lastName', $lastName);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $password);
        $stmt->bindValue(':isAdmin', $isAdmin);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function get($id = null, $orderBy = null, $desc = false) {
        $allowedFields = ['firstName', 'lastName', 'email', 'isAdmin'];
        
        if (!in_array($orderBy, $allowedFields)) {
            return false;
        }

        if (is_null($id)) {
            $sql = "SELECT * FROM dashboarduser";

            if (!is_null($orderBy)) {
                $sql .= " ORDER BY " . $orderBy;
                if ($desc) {
                    $sql .= " DESC";
                }
            }
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

    public function set($id, $field, $value) {
        $allowedFields = ['firstName', 'lastName', 'email', 'isAdmin'];
        
        if (!in_array($field, $allowedFields)) {
            return false;
        }

        $sql = "UPDATE dashboarduser SET $field = :value WHERE id = :id";
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
        $sql = "SELECT id FROM dashboarduser WHERE id = :id";
        $stmt = $this->db_conn->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        if ($stmt && $stmt->rowCount() > 0) {
            $deleteSql = "DELETE FROM dashboarduser WHERE id = :id";
            $deleteStmt = $this->db_conn->prepare($deleteSql);
            $deleteStmt->bindValue(':id', $id);
            $deleteStmt->execute();
            return true;
        }

        return false;
    }
}