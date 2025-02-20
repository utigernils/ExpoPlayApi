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

    public function getPlayer($playerId) {
        $player = $this->playerModell->get($playerId);

        if ($player === false) {
            $this->response->error(message:'Your request was blocked due to invalid credentials');
        }
        
        if (!empty($player)) {
            $this->response->setHeader(200);

            $response = json_encode($player[0]);
            echo $response;
            exit();

        } else {
            $this->response->error(message:'Player not found', responseCode:404);
        }
    }

    public function updatePlayer($playerId) {
        $player = $this->playerModell->get($playerId);

        if (empty($player)) {
            $this->response->error(message:'Player not found', responseCode:404);
        }

        $jsonData = json_decode(file_get_contents('php://input'), true);

        if (empty($jsonData)) {
            $this->response->error(message:'No data provided', responseCode:400);
        }

        foreach ($jsonData as $field => $value) {
            $player = $this->playerModell->set($playerId, $field, $value);
            
            if ($player === false) {
                $this->response->error(message:'Your request was blocked due to invalid credentials');
            }
        }

        $this->response->message(message:'Player updated successfully', responseCode:200);
    }

    public function removePlayer($playerId) {
        $player = $this->playerModell->get($playerId);

        if (empty($player)) {
            $this->response->error(message:'Player not found', responseCode:404);
        }

        $this->playerModell->delete($playerId);
        $this->response->message(message:'Player deleted successfully', responseCode:200);
    }

    public function getAllPlayers() {
        $orderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : null;
        $direction = isset($_GET['desc']) ? $_GET['desc'] : null;

        $player = $this->playerModell->get(orderBy: $orderBy, desc: $direction);

        if ($player === false) {
            $this->response->error(message:'Your request was blocked due to invalid credentials');
        }
        
        if (!empty($player)) {
            $this->response->setHeader(200);

            $response = json_encode($player);
            echo $response;
            exit();

        } else {
            $this->response->error(message:'No Players found', responseCode:404);
        }
    }
}