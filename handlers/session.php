<?php
class Session {
    private $sessionId;
    private $sessionData;
    
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->sessionId = session_id();
        $this->sessionData = &$_SESSION;
    }
    
    public function set($key, $value) {
        $this->sessionData[$key] = $value;
    }
    
    public function get($key, $default = null) {
        return isset($this->sessionData[$key]) ? $this->sessionData[$key] : $default;
    }
    
    public function remove($key) {
        if (isset($this->sessionData[$key])) {
            unset($this->sessionData[$key]);
        }
    }
    
    public function clear() {
        session_unset();
        session_destroy();
    }

    public function getId() {
        return $this->sessionId;
    }

    public function checkLogin() {
        if ($this->get('user_id') != null) {
            return true;
        } else {
            return false;
        }
    }
    
    public function checkAdmin() {
        if ($this->get('isAdmin') == 1) {
            return true;
        } else {
            return false;
        }
    }
}