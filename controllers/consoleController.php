<?php
class consoleController {

    private $session;
    private $consoleModell; 

    public function __construct($session, $dataModell) {
        $this->session = $session;
        $this->consoleModell = $dataModell;
    }

    public function getConsole($consoleId) {
        $update = $this->consoleModell->get(orderBy: 'nadme', desc: false);



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