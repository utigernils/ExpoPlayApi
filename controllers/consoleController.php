<?php
class consoleController {

    private $session;
    private $consoleModell; 

    public function __construct($session, $dataModell) {
        $this->session = $session;
        $this->consoleModell = $dataModell;
    }
}