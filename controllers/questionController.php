<?php
class questionController {

    private $session;
    private $questionModell; 

    public function __construct($session, $dataModell) {
        $this->session = $session;
        $this->questionModell = $dataModell;
    }
}