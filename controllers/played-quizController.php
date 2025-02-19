<?php
class playedquizController {

    private $session;
    private $quizModell; 

    public function __construct($session, $dataModell) {
        $this->session = $session;
        $this->quizModell = $dataModell;
    }
}