<?php
require_once 'utils/response.php';

class expoController {

    private $session;
    private $expoModell; 
    private $response;

    public function __construct($session, $dataModell) {
        $this->session = $session;
        $this->expoModell = $dataModell;
        $this->response = new Response();
    }

    public function getExpo($expoId) {
        $expo = $this->expoModell->get($expoId);

        if ($expo === false) {
            $this->response->error(message:'Your request was blocked due to invalid credentials');
        }
        
        if (!empty($expo)) {
            $this->response->setHeader(200);

            $response = json_encode($expo[0]);
            echo $response;
            exit();

        } else {
            $this->response->error(message:'Expo not found', responseCode:404);
        }
    }

    public function updateExpo($expoId) {
        $expo = $this->expoModell->get($expoId);

        if (empty($expo)) {
            $this->response->error(message:'Expo not found', responseCode:404);
        }

        $jsonData = json_decode(file_get_contents('php://input'), true);

        if (empty($jsonData)) {
            $this->response->error(message:'No data provided', responseCode:400);
        }

        foreach ($jsonData as $field => $value) {
            $expo = $this->expoModell->set($expoId, $field, $value);
            
            if ($expo === false) {
                $this->response->error(message:'Your request was blocked due to invalid credentials');
            }
        }

        $this->response->message(message:'Expo updated successfully', responseCode:200);
    }

    public function deleteExpo($expoId) {
        $expo = $this->expoModell->get($expoId);

        if (empty($expo)) {
            $this->response->error(message:'Expo not found', responseCode:404);
        }

        $this->expoModell->delete($expoId);
        $this->response->message(message:'Expo deleted successfully', responseCode:200);

    }

    public function getAllExpos() {
        $orderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : null;
        $direction = isset($_GET['desc']) ? $_GET['desc'] : null;

        $expo = $this->expoModell->get(orderBy: $orderBy, desc: $direction);

        if ($expo === false) {
            $this->response->error(message:'Your request was blocked due to invalid credentials');
        }
        
        if (!empty($expo)) {
            $this->response->setHeader(200);

            $response = json_encode($expo);
            echo $response;
            exit();

        } else {
            $this->response->error(message:'No Expos found', responseCode:404);
        }
    }

    public function createExpo() {
        $jsonData = json_decode(file_get_contents('php://input'), true);
    
        if (empty($jsonData)) {
            $this->response->error(message: 'No data provided', responseCode: 400);
        }
    
        if (!isset($jsonData['name']) || empty($jsonData['name'])) {
            $this->response->error(message: 'Name is required', responseCode: 400);
        }
    
        if (!isset($jsonData['startsOn']) || empty($jsonData['startsOn'])) {
            $this->response->error(message: 'Start date is required', responseCode: 400);
        }
    
        if (!isset($jsonData['endsOn']) || empty($jsonData['endsOn'])) {
            $this->response->error(message: 'End date is required', responseCode: 400);
        }
    
        if (!isset($jsonData['location']) || empty($jsonData['location'])) {
            $this->response->error(message: 'Location is required', responseCode: 400);
        }
    
        if (strtotime($jsonData['startsOn']) === false) {
            $this->response->error(message: 'Invalid start date format', responseCode: 400);
        }
    
        if (strtotime($jsonData['endsOn']) === false) {
            $this->response->error(message: 'Invalid end date format', responseCode: 400);
        }
    
        if (strtotime($jsonData['startsOn']) > strtotime($jsonData['endsOn'])) {
            $this->response->error(message: 'Start date must be before end date', responseCode: 400);
        }
    
        $name = $jsonData['name'];
        $startsOn = $jsonData['startsOn'];
        $endsOn = $jsonData['endsOn'];
        $location = $jsonData['location'];
        $isActive = isset($jsonData['isActive']) ? filter_var($jsonData['isActive'], FILTER_VALIDATE_BOOLEAN) : true;
    
        $result = $this->expoModell->create(name: $name, startsOn: $startsOn, endsOn: $endsOn, location: $location, isActive: $isActive);
    
        if ($result === false) {
            $this->response->error(message: 'Expo could not be created', responseCode: 500);
        } else {
            $this->response->message(message: 'Expo created successfully', responseCode: 201);
        }
    }
    
}