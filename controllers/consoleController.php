<?php
class consoleController {

    private $session;
    private $consoleModell; 

    public function __construct($session, $dataModell) {
        $this->session = $session;
        $this->consoleModell = $dataModell;
    }

    public function getConsole($consoleId) {
        $update = $this->consoleModell->delete('9984bc2e-ef63-11ef-b8ed-70a8d3185f5f');

        echo $update;

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