<?php
require_once 'utils/response.php';

class loginController {
    private $session;
    private $db_conn; 
    private $response;

    public function __construct($session, $db) {
        $this->session = $session;
        $this->db_conn = $db->getConnection();
        $this->response = new Response();
    }

    public function checkLoginState() {
        $state = $this->session->checkLogin();
        if ($state) {
            echo json_encode([
                'state' => true
            ]);
        } else {
            echo json_encode([
                'state' => false
            ]);
        }
    }

    public function login() {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (!isset($data['email']) || !isset($data['password']) || empty($data['email']) || empty($data['password'])) {
            echo json_encode([
                'error' => 'Email and password are required'
            ]);
            return;
        }

        $email = $data['email'];
        $password = $data['password'];

        $stmt = $this->db_conn->prepare("SELECT id, email, firstName, lastName, password FROM dashboarduser WHERE email = ?");
        $stmt->execute([$email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $user['password'])) {
            $this->session->set('userId', $user['id']); 
                
            echo json_encode([
                'msg' => 'Successfully logged in',
                'user' => [
                    'id' => $user['id'],
                    'firstName' => $user['firstName'],
                    'lastName' => $user['lastName'],
                    'email' => $user['email']
                ]
                ]);
        } else {
            echo json_encode([
                'error' => 'Invalid credentials'
            ]);
        }
    }

    public function logout() {
        $this->session->clear();
        echo json_encode(['msg' => 'Successfully logged out']);
    }
}