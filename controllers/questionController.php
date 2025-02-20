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

    public function getAllQuestions() {

    }

    public function addQuestion() {

    }

    public function getQuestion() {

    }

    public function updateQuestion() {

    }

    public function deleteQuestion() {
        
    }
}