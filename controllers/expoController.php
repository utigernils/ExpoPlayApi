<?php
require_once 'utils/response.php';

class expoController {

    private $session;
    private $expoModell; 
    private $response;

    public function __construct($session, $dataModell) {
        $this->session = $session;
        $this->expoModell = $dataModell;
        $this->response = new Response();
    }

    public function getExpo() {

    }

    public function updateExpo() {

    }

    public function deleteExpo() {

    }

    public function getAllExpos() {

    }

    public function createExpo() {
        
    }
}