<?php
require_once 'utils/response.php';

class consoleApiController {

    private $session;
    private $consoleModell; 
    private $quizModell;
    private $expoModell;
    private $response;

    public function __construct($session, $consoleDataModell, $quizDataModell, $expoDataModell) {
        $this->session = $session;
        $this->consoleModell = $consoleDataModell;
        $this->quizModell = $quizDataModell;
        $this->expoModell = $expoDataModell;
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

        $console = $this->consoleModell->get($consoleId)[0];
        
        $expoId = $console['currentExpo'];
        $quizId = $console['currentQuiz'];

        $quiz = $this->quizModell->get($quizId)[0];
        $expo = $this->expoModell->get($expoId)[0];

        $response = [
            'console' => $console,
            'quiz' => $quiz,
            'expo' => $expo
        ];

        echo json_encode($response);

        $this->response->setHeader(200);
        exit();
    }
}