<?php
class userController {

    private $session;
    private $userModell; 

    public function __construct($session, $dataModell) {
        $this->session = $session;
        $this->userModell = $dataModell;
    }

    private function checkParameter($param) {
        if ($param == null || empty($param)) {
            http_response_code(400);
            echo json_encode(array("error" => "One or more required parameter is missing or empty"));
            exit();
        }
    }

    private function checkUser($userId) {
        $user = $this->userModell->get($userId);

        if ($user == null) {
            http_response_code(404);
            echo json_encode(array("error" => "User not found"));
            exit();
        }
    }

    public function getUserById($userId = null) {
        $this->checkParameter($userId);
        $this->checkUser($userId);

        $user = $this->userModell->get($userId);

        http_response_code(200);
        echo json_encode(array(
            "id" => $user[0]['id'],
            "firstName" => $user[0]['firstName'],
            "lastName" => $user[0]['lastName'],
            "email" => $user[0]['email'],
            "isAdmin" => $user[0]['isAdmin']
        ));
    }

    public function updateUser($userId = null) {
        $this->checkParameter($userId);
        $this->checkUser($userId);

        $jsonData = file_get_contents('php://input');
        $requestData = json_decode($jsonData, true);

        $allowedKeys = ['id', 'firstName', 'lastName', 'email', 'isAdmin'];

        if ($requestData) {
            foreach ($requestData as $key => $value) {
                if (!in_array($key, $allowedKeys)) {
                    http_response_code(400);
                    echo json_encode(array("error" => "Invalid field: " . $key));
                    exit();
                }
            }
        }

        $updateData = $requestData;

        if ($this->userModell->update($userId, $updateData) == 1) {
            http_response_code(201);
            echo json_encode(array("msg" => "User updated successfully"));
            exit();
        } else {
            http_response_code(500);
            echo json_encode(array("error" => "An unknown error occurred while updating the user"));
            exit();
        }
    }

    public function deleteUser($userId = null) {
        $this->checkParameter($userId);
        $this->checkUser($userId);

        if ($this->userModell->delete($userId) == 1) {
            http_response_code(201);
            echo json_encode(array("msg" => "User deleted successfully"));
            exit();
        } else {
            http_response_code(500);
            echo json_encode(array("error" => "An unknown error occurred while deleting the user"));
            exit();
        }
    }

    public function getUser() {
        $user = $this->userModell->get();

        http_response_code(200);
        $users = array();
        foreach ($user as $userData) {
            $users[] = array(
                "id" => $userData['id'],
                "firstName" => $userData['firstName'],
                "lastName" => $userData['lastName'],
                "email" => $userData['email'],
                "isAdmin" => $userData['isAdmin']
            );
        }
        echo json_encode(array("users" => $users));

    }

    public function registerUser() {
        $jsonData = file_get_contents('php://input');
        $jsonData = json_decode($jsonData, true);

        $requiredKeys = ['firstName', 'lastName', 'email','password', 'isAdmin'];
        
        foreach ($requiredKeys as $key) {
            if (!isset($jsonData[$key])) {
                http_response_code(400);
                echo json_encode(array("error" => "Missing required field: " . $key));
                exit();
            }
        }
 
        if ($this->userModell->create($jsonData) == 1) {
            http_response_code(201);
            echo json_encode(array("msg" => "User created successfully"));
            exit();
        } else {
            http_response_code(500);
            echo json_encode(array("error" => "An unknown error occurred while creating the user"));
            exit();
        }
    }
 
}