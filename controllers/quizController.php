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

    public function getQuiz() {

    }

    public function updateQuiz() {

    }

    public function deleteQuiz() {

    }

    public function getAllQuizzes() {

    }

    public function createQuiz() {
        
    }
}