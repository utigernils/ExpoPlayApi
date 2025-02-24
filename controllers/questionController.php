<?php
require_once 'utils/response.php';

class questionController {

    private $session;
    private $questionModell; 
    private $response;

    public function __construct($session, $dataModell) {
        $this->session = $session;
        $this->questionModell = $dataModell;
        $this->response = new Response();
    }

    public function getAllQuestions($quizId) {
        $orderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : null;
        $direction = isset($_GET['desc']) ? $_GET['desc'] : null;

        $question = $this->questionModell->get(orderBy: $orderBy, desc: $direction, quizId: $quizId);

        if ($question === false) {
            $this->response->error(message:'Your request was blocked due to invalid credentials');
        }
        
        if (!empty($question)) {
            $this->response->setHeader(200);

            $response = json_encode($question);
            echo $response;
            exit();

        } else {
            $this->response->error(message:'No Players found', responseCode:404);
        }
    }

    public function addQuestion($quizId) {
        $jsonData = json_decode(file_get_contents('php://input'), true);

        if (empty($jsonData)) {
            $this->response->error(message:'No data provided', responseCode:400);
        }
        
        if (!isset($jsonData['Question']) | !isset($jsonData['questionType'])) {
            $this->response->error(message:'Question and questionType are required', responseCode:400);
        }

        $question = $jsonData['Question'];
        $questionType = $jsonData['questionType'];

        $result = $this->questionModell->create($quizId, $question, $questionType);

        if ($result === false) {
            $this->response->error(message:'Question could not be created', responseCode:500);
        } else {
            $this->response->message(message:'Question created', responseCode:201);
        }
    }

    public function getQuestion($quizId, $questionId) {
        $question = $this->questionModell->get($quizId, $questionId);

        if ($question === false) {
            $this->response->error(message:'Your request was blocked due to invalid credentials');
        }
        
        if (!empty($question)) {
            $this->response->setHeader(200);

            $response = json_encode($question[0]);
            echo $response;
            exit();

        } else {
            $this->response->error(message:'Question not found', responseCode:404);
        }
    }

    public function updateQuestion($quizId, $questionId) {
        $question = $this->questionModell->get($quizId, $questionId);

        if (empty($question)) {
            $this->response->error(message:'Question not found', responseCode:404);
        }

        $jsonData = json_decode(file_get_contents('php://input'), true);

        if (empty($jsonData)) {
            $this->response->error(message:'No data provided', responseCode:400);
        }

        foreach ($jsonData as $field => $value) {
            $question = $this->questionModell->set($questionId, $field, $value);
            
            if ($question === false) {
                $this->response->error(message:'Your request was blocked due to invalid credentials');
            }
        }

        $this->response->message(message:'Question updated successfully', responseCode:200);
    }

    public function deleteQuestion($quizId, $questionId) {
        $question = $this->questionModell->get($quizId, $questionId);

        if (empty($question)) {
            $this->response->error(message:'Question not found', responseCode:404);
        }

        $this->questionModell->delete($questionId);
        $this->response->message(message:'Question deleted successfully', responseCode:200);
    }
}