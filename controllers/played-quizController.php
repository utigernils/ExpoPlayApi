<?php
require_once 'utils/response.php';

class playedquizController {

    private $session;
    private $quizModell; 
    private $response;

    public function __construct($session, $dataModell) {
        $this->session = $session;
        $this->quizModell = $dataModell;
        $this->response = new Response();
    }

    public function getPlayedQuiz($pquizId) {
        $quiz = $this->quizModell->get($pquizId);

        if ($quiz === false) {
            $this->response->error(message:'Your request was blocked due to invalid credentials');
        }
        
        if (!empty($quiz)) {
            $this->response->setHeader(200);

            $response = json_encode($quiz[0]);
            echo $response;
            exit();

        } else {
            $this->response->error(message:'PlayedQuiz not found', responseCode:404);
        }
    }

    public function deletePlayedQuiz($pquizId) {
        $quiz = $this->quizModell->get($pquizId);

        if (empty($quiz)) {
            $this->response->error(message:'PlayedQuiz not found', responseCode:404);
        }

        $this->quizModell->delete($pquizId);
        $this->response->message(message:'PlayedQuiz deleted successfully', responseCode:200);
    }

    public function getAllPlayedQuizzes() {
        $orderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : null;
        $direction = isset($_GET['desc']) ? $_GET['desc'] : null;

        $quiz = $this->quizModell->get(orderBy: $orderBy, desc: $direction);

        if ($quiz === false) {
            $this->response->error(message:'Your request was blocked due to invalid credentials');
        }
        
        if (!empty($quiz)) {
            $this->response->setHeader(200);

            $response = json_encode($quiz);
            echo $response;
            exit();

        } else {
            $this->response->error(message:'No Quizzes found', responseCode:404);
        }
    }
}