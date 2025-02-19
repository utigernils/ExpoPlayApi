<?php
class DashboardUser_crtl {

    private $session;
    public function __construct($session) {
        $this->session = $session;
    }

    public function login() {
        $this->session->set('user_id', '123');
    }

    public function logout() {
        $this->session->clear();
    }
}