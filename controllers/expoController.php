<?php
class expoController {

    private $session;
    private $expoModell; 

    public function __construct($session, $dataModell) {
        $this->session = $session;
        $this->expoModell = $dataModell;
    }
}