<?php
require_once 'utils/response.php';

class loginController
{
    private $session;
    private $db_conn;
    private $response;

    public function __construct($session, $db)
    {
        $this->session = $session;
        $this->db_conn = $db->getConnection();
        $this->response = new Response();
    }

	public function checkLoginState()
	{
		$state = $this->session->checkLogin();
		if ($state) {
			$userId = $this->session->get('userId');

			$stmt = $this->db_conn->prepare("SELECT email, firstName, lastName, isAdmin FROM dashboarduser WHERE id = ?");
			$stmt->execute([$userId]);

			$user = $stmt->fetch(PDO::FETCH_ASSOC);

			echo json_encode(['state' => true, 'user' => $userId, 'isAdmin' => $user['isAdmin'], 'email' => $user['email'], 'firstName' => $user['firstName'], 'lastName' => $user['lastName']]);
		} else {
			echo json_encode([
				'state' => false
			]);
		}
	}


    public function login()
    {
        if($this->session->checkLogin()) {
            $this->response->message('You are already logged in', 200);
        }

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (!isset($data['email']) || !isset($data['password']) || empty($data['email']) || empty($data['password'])) {
            $this->response->error('Password and email are required');
        }

        $email = $data['email'];
        $password = $data['password'];

        $stmt = $this->db_conn->prepare("SELECT id, email, firstName, lastName, password FROM dashboarduser WHERE email = ?");
        $stmt->execute([$email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $user['password'])) {
            $this->session->set('userId', $user['id']);
			
			        if (session_status() === PHP_SESSION_ACTIVE) {
            setcookie(session_name(), session_id(), [
                'expires' => time() + 3600,
                'path' => '/',
                'domain' => 'expoplayapi.utigernils.ch', // your API domain
                'secure' => true,
                'httponly' => true,
                'samesite' => 'None'
            ]);
        }

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
            $this->response->error('Invalid credentials', 401);
        }
    }

    public function logout()
    {
        $this->session->clear();
        $this->response->message('Successfully logged out');
    }
}