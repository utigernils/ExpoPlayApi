<?php
class playerController {

    private $session;
    private $playerModell; 

    public function __construct($session, $dataModell) {
        $this->session = $session;
        $this->playerModell = $dataModell;
    }
}