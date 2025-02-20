<?php
require_once 'utils/response.php';

class playerController {

    private $session;
    private $playerModell; 
    private $response;

    public function __construct($session, $dataModell) {
        $this->session = $session;
        $this->playerModell = $dataModell;
        $this->response = new Response();
    }

    public function getPlayer() {

    }

    public function updatePlayer() {

    }

    public function removePlayer() {

    }

    public function getAllPlayers() {

    }
}