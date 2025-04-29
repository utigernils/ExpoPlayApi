<?php
require_once 'utils/response.php';

class consoleApiController {

    private $session;
    private $consoleModell; 
    private $quizModell;
    private $expoModell;
    private $playedQuizzesModell;
    private $response;

    public function __construct($session, $consoleDataModell, $quizDataModell, $expoDataModell, $playedQuizzesDataModell) {
        $this->session = $session;
        $this->consoleModell = $consoleDataModell;
        $this->quizModell = $quizDataModell;
        $this->expoModell = $expoDataModell;
        $this->playedQuizzesModell = $playedQuizzesDataModell;
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

    public function startQuiz($consoleId) {
        $this->checkConsoleId($consoleId);
        $postData = json_decode(file_get_contents('php://input'), true);

        if (!isset($postData['player'], $postData['startedOn'])) {
            $this->response->error(message: 'Missing required fields', responseCode: 400);
        }

        if (!preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $postData['startedOn'])) {
            $this->response->error(message: 'Invalid timestamp format for startedOn', responseCode: 400);
        }

        $player = $postData['player'];
        $startedOn = $postData['startedOn'];

        $console = $this->consoleModell->get($consoleId)[0];

        $quizName = $postData['quizName'] ?? null;
        
        $endedOn = $postData['endedOn'] ?? null;
        $correctAnswers = $postData['correctAnswers'] ?? null;
        $wrongAnswers = $postData['wrongAnswers'] ?? null;
        

        $expo = $console['currentExpo'];
        $quiz = $console['currentQuiz'];

        $expoName = $this->expoModell->get($expo)[0]['name'];
        $quizName = $this->quizModell->get($quiz)[0]['name'];

        $result = $this->playedQuizzesModell->create($player, $quiz, $startedOn, $quizName, $expo, $endedOn, $correctAnswers, $wrongAnswers, $expoName);

        if ($result !== false) {
            echo json_encode(['playedQuizId' => $result, 'msg' => 'Quiz started successfully']);

            $this->response->setHeader(201);
            exit();
        } else {
            $this->response->error(message: 'Failed to start quiz', responseCode: 500);
        }
        
    }

    public function endQuiz($consoleId) {
        $this->checkConsoleId($consoleId);
        $postData = json_decode(file_get_contents('php://input'), true);

        if (!isset($postData['id'], $postData['endedOn'], $postData['correctAnswers'], $postData['wrongAnswers'])) {
            $this->response->error(message: 'Missing required fields', responseCode: 400);
        }

        if (!preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $postData['endedOn'])) {
            $this->response->error(message: 'Invalid timestamp format for endedOn', responseCode: 400);
        }

        $id = $postData['id'];
        
        if(empty($this->playedQuizzesModell->get($id))) {
            $this->response->error(message: 'Quiz not found', responseCode: 404);
        }

        $endedOn = $postData['endedOn'];
        $correctAnswers = $postData['correctAnswers'];
        $wrongAnswers = $postData['wrongAnswers'];

        $result = $this->playedQuizzesModell->set($id, 'endedOn', $endedOn);
        $result &= $this->playedQuizzesModell->set($id, 'correctAnswers', $correctAnswers);
        $result &= $this->playedQuizzesModell->set($id, 'wrongAnswers', $wrongAnswers);

        if ($result) {
            $this->response->message(message: 'Quiz ended successfully', responseCode: 200);
        } else {
            $this->response->error(message: 'Failed to end quiz', responseCode: 500);
        }
    }
}