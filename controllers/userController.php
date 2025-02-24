<?php
require_once 'utils/response.php';

class userController {

    private $session;
    private $userModell; 
    private $response;

    public function __construct($session, $dataModell) {
        $this->session = $session;
        $this->userModell = $dataModell;
        $this->response = new Response();
    }

    public function getUserById($userId) {
        $user = $this->userModell->get($userId);

        if ($user === false) {
            $this->response->error(message:'Your request was blocked due to invalid credentials');
        }
        
        if (!empty($user)) {
            $this->response->setHeader(200);

            unset($user[0]['password']);
            
            $response = json_encode($user[0]);
            echo $response;
            exit();

        } else {
            $this->response->error(message:'User not found', responseCode:404);
        }
    }

    public function updateUser($userId) {
        $user = $this->userModell->get($userId);

        if (empty($user)) {
            $this->response->error(message:'User not found', responseCode:404);
        }

        $jsonData = json_decode(file_get_contents('php://input'), true);

        if (empty($jsonData)) {
            $this->response->error(message:'No data provided', responseCode:400);
        }

        foreach ($jsonData as $field => $value) {
            $user = $this->userModell->set($userId, $field, $value);
            
            if ($user === false) {
                $this->response->error(message:'Your request was blocked due to invalid credentials');
            }
        }

        $this->response->message(message:'User updated successfully', responseCode:200);
    }

    public function deleteUser($userId) {
        $user = $this->userModell->get($userId);

        if (empty($user)) {
            $this->response->error(message:'User not found', responseCode:404);
        }

        $this->userModell->delete($userId);
        $this->response->message(message:'User deleted successfully', responseCode:200);
    }

    public function getUser() {
        $orderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : null;
        $direction = isset($_GET['desc']) ? $_GET['desc'] : null;

        $user = $this->userModell->get(orderBy: $orderBy, desc: $direction);

        if ($user === false) {
            $this->response->error(message:'Your request was blocked due to invalid credentials');
        }
        
        if (!empty($user)) {
            $this->response->setHeader(200);

            $userData = array_map(function($user) {
                unset($user['password']);
                return $user;
            }, $user);
            
            $response = json_encode($userData);
            echo $response;
            exit();

        } else {
            $this->response->error(message:'No Users found', responseCode:404);
        }
    }

    public function registerUser() {
        $jsonData = json_decode(file_get_contents('php://input'), true);

        if (empty($jsonData)) {
            $this->response->error(message:'No data provided', responseCode:400);
        }
        
        if (!isset($jsonData['firstName'])) {
            $this->response->error(message:'First name is required', responseCode:400);
        }
        if (!isset($jsonData['lastName'])) {
            $this->response->error(message:'Last name is required', responseCode:400);
        }
        if (!isset($jsonData['email'])) {
            $this->response->error(message:'Email is required', responseCode:400);
        }
        if (!isset($jsonData['password'])) {
            $this->response->error(message:'Password is required', responseCode:400);
        }

        $firstName = $jsonData['firstName'];
        $lastName = $jsonData['lastName'];
        $email = $jsonData['email'];
        $password = password_hash($jsonData['password'], PASSWORD_ARGON2I);
        

        $result = $this->userModell->create($firstName, $lastName, $email, $password);

        if ($result === false) {
            $this->response->error(message:'User could not be created', responseCode:500);
        } else {
            $this->response->message(message:'User created', responseCode:201);
        }
    }
 
}