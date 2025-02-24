<?php
require_once 'utils/response.php';

class quizController {

    private $session;
    private $quizModell; 
    private $response;

    public function __construct($session, $dataModell) {
        $this->session = $session;
        $this->quizModell = $dataModell;
        $this->response = new Response();
    }

    public function getQuiz($quizId) {
        $quiz = $this->quizModell->get($quizId);

        if ($quiz === false) {
            $this->response->error(message:'Your request was blocked due to invalid credentials');
        }
        
        if (!empty($quiz)) {
            $this->response->setHeader(200);

            $response = json_encode($quiz[0]);
            echo $response;
            exit();

        } else {
            $this->response->error(message:'Quiz not found', responseCode:404);
        }
    }

    public function updateQuiz($quizId) {
        $quiz = $this->quizModell->get($quizId);

        if (empty($quizId)) {
            $this->response->error(message:'Quiz not found', responseCode:404);
        }

        $jsonData = json_decode(file_get_contents('php://input'), true);

        if (empty($jsonData)) {
            $this->response->error(message:'No data provided', responseCode:400);
        }

        foreach ($jsonData as $field => $value) {
            $quiz = $this->quizModell->set($quizId, $field, $value);
            
            if ($quiz === false) {
                $this->response->error(message:'Your request was blocked due to invalid credentials');
            }
        }

        $this->response->message(message:'Quiz updated successfully', responseCode:200);

    }

    public function deleteQuiz($quizId) {
        $quiz = $this->quizModell->get($quizId);

        if (empty($quiz)) {
            $this->response->error(message:'Quiz not found', responseCode:404);
        }

        $this->quizModell->delete($quizId);
        $this->response->message(message:'Quiz deleted successfully', responseCode:200);
    }

    public function getAllQuizzes() {
        $orderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : null;
        $direction = isset($_GET['desc']) ? $_GET['desc'] : null;

        $quiz = $this->quizModell->get(orderBy: $orderBy, desc: $direction);

        if ($quiz === false) {
            $this->response->error(message:'Your request was blocked due to invalid credentials');
        }
        
        if (!empty($quiz)) {
            $this->response->setHeader(200);

            $response = json_encode($quiz);
            echo $response;
            exit();

        } else {
            $this->response->error(message:'No Quizzes found', responseCode:404);
        }
    }

    public function createQuiz() {
        $jsonData = json_decode(file_get_contents('php://input'), true);

        if (empty($jsonData)) {
            $this->response->error(message:'No data provided', responseCode:400);
        }
        
        if (!isset($jsonData['name'])) {
            $this->response->error(message:'Name is required', responseCode:400);
        }

        $name = $jsonData['name'];

        $result = $this->quizModell->create($name, true);

        if ($result === false) {
            $this->response->error(message:'Quiz could not be created', responseCode:500);
        } else {
            $this->response->message(message:'Quiz created', responseCode:201);
        }
    }
}