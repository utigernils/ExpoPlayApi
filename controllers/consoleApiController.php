<?php
require_once 'utils/response.php';

class consoleApiController {

    private $session;
    private $consoleModell; 
    private $quizModell;
    private $response;

    public function __construct($session, $consoleDataModell, $quizDataModell) {
        $this->session = $session;
        $this->consoleModell = $consoleDataModell;
        $this->quizModell = $quizDataModell;
        $this->response = new Response();
    }

    private function checkConsoleId($consoleId) {
        $console = $this->consoleModell->get($consoleId);

        if (empty($console)) {
            $this->response->error(message:'Console not found', responseCode:404);
        }

        return $console;
    }

    public function getConsoleInfo($consoleId) {
        $this->checkConsoleId($consoleId);
        $this->response->message(message:'Der neue endpoint funktioniert. Die Console id ist: '.$consoleId, responseCode:200);
    }
}