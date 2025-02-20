<?php
require_once 'utils/response.php';

class consoleController {

    private $session;
    private $consoleModell; 
    private $response;

    public function __construct($session, $dataModell) {
        $this->session = $session;
        $this->consoleModell = $dataModell;
        $this->response = new Response();
    }

    public function getConsole($consoleId) {
        $console = $this->consoleModell->get($consoleId);
        
        if (!empty($console)) {
            return $this->response->message(message:'is not empty');
        } else {
            return $this->response->error(message:'is empty');
        }
        
        
    }

    public function updateConsole() {

    }

    public function unlinkConsole() {

    }

    public function getAllConsoles() {

    }

    public function registerConsole() {
        
    }
}