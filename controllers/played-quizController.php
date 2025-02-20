<?php
require_once 'utils/response.php';

class playedquizController {

    private $session;
    private $quizModell; 
    private $response;

    public function __construct($session, $dataModell) {
        $this->session = $session;
        $this->quizModell = $dataModell;
        $this->response = new Response();
    }

    public function getPlayedQuiz() {

    }

    public function deletePlayedQuiz() {

    }

    public function getAllPlayedQuizzes() {

    }
    
}