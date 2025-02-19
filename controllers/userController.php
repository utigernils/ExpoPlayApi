<?php
class userController {

    private $session;
    private $userModell; 

    public function __construct($session, $dataModell) {
        $this->session = $session;
        $this->userModell = $dataModell;
    }

    public function login() {
        $this->session->set('user_id', '123');
    }

    public function logout() {
        $this->session->clear();
    }
}