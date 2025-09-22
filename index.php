<?php
require_once 'handlers/config.php';
require_once 'handlers/router.php';
require_once 'handlers/session.php';
require_once 'handlers/db.php';

require_once 'modells/Console.php';
require_once 'modells/DashboardUser.php';
require_once 'modells/Expo.php';
require_once 'modells/PlayedQuizzes.php';
require_once 'modells/Player.php';
require_once 'modells/Questions.php';
require_once 'modells/Quiz.php';

require_once 'controllers/consoleController.php';
require_once 'controllers/expoController.php';
require_once 'controllers/played-quizController.php';
require_once 'controllers/playerController.php';
require_once 'controllers/questionController.php';
require_once 'controllers/quizController.php';
require_once 'controllers/userController.php';

require_once 'controllers/consoleApiController.php';

require_once 'controllers/loginController.php';

$config = new Config(configPath:
    'config.ini'
);



$allowedOrigins = [
    'http://localhost:5173',
    'http://localhost',
    'https://expoplay.utigernils.ch',
    'https://expoplaydashboard.utigernils.ch',
    'http://localhost:4200',
    'https://editor.swagger.io'
    // Do NOT include '*'
];

if (isset($_SERVER['HTTP_ORIGIN'])) {
    $origin = $_SERVER['HTTP_ORIGIN'];
    if (in_array($origin, $allowedOrigins)) {
        header("Access-Control-Allow-Origin: $origin");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
    }
}

$router = new Router(
    contentType: $config->get('content_type'),
    basePath:$config->get('base_path')
);

$db = new db(
    host:$config->get('db_host'), 
    db:$config->get('db_name'),
    user: $config->get('db_user'), 
    pass:$config->get('db_pass')
);

$consoleModell = new Console($db);
$dashboardUserModell = new DashboardUser($db);
$expoModell = new Expo($db);
$playedQuizzesModell = new playedQuizzes($db);
$playerModell = new Player($db);
$questionsModell = new Questions($db);
$quizModell = new Quiz($db);

$session = new Session($dashboardUserModell);

$consoleController = new consoleController($session, $consoleModell);
$expoController = new expoController($session, $expoModell);
$playedquizController = new playedquizController($session, $playedQuizzesModell);
$playerController = new playerController($session, $playerModell);
$questionController = new questionController($session, $questionsModell);
$quizController = new quizController($session, $quizModell);
$userController = new userController($session, $dashboardUserModell);


$consoleApiController = new consoleApiController($session, $consoleModell, $quizModell, $expoModell, $playedQuizzesModell, $playerModell, $questionsModell);

$loginController = new loginController($session, $db);

if ($config->get('mode') === 'development') {
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit();
    }
}

$router->addRoute(
    method: 'GET', 
    path: '/user/{userId}', 
    callback: [$userController, 'getUserById'],
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);  

$router->addRoute(
    method: 'PUT', 
    path: '/user/{userId}', 
    callback: [$userController, 'updateUser'],
    permissionCallback: [$session, 'checkAdmin'], 
    loginCallback: [$session, 'checkLogin']
);  

$router->addRoute(
    method: 'DELETE', 
    path: '/user/{userId}', 
    callback: [$userController, 'deleteUser'],
    permissionCallback: [$session, 'checkAdmin'], 
    loginCallback: [$session, 'checkLogin']
);  

$router->addRoute(
    method: 'GET', 
    path: '/user', 
    callback: [$userController, 'getUser'],
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'POST', 
    path: '/user', 
    callback: [$userController, 'registerUser'],
    permissionCallback: [$session, 'checkAdmin'], 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'GET', 
    path: '/console/{consoleId}', 
    callback: [$consoleController, 'getConsole'],
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'PUT', 
    path: '/console/{consoleId}', 
    callback: [$consoleController, 'updateConsole'],
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'DELETE', 
    path: '/console/{consoleId}', 
    callback: [$consoleController, 'unlinkConsole'],
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'GET', 
    path: '/console', 
    callback: [$consoleController, 'getAllConsoles'],
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'POST', 
    path: '/console', 
    callback: [$consoleController, 'registerConsole'],
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'GET', 
    path: '/player/{playerId}', 
    callback: [$playerController, 'getPlayer'],
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'PUT', 
    path: '/player/{playerId}', 
    callback: [$playerController, 'updatePlayer'],
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'DELETE', 
    path: '/player/{playerId}', 
    callback: [$playerController, 'removePlayer'],
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'GET', 
    path: '/player', 
    callback: [$playerController, 'getAllPlayers'],
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'POST',
    path: '/player',
    callback: [$playerController, 'createPlayer'],
    permissionCallback: true,
    loginCallback: true,
);

$router->addRoute(
    method: 'GET', 
    path: '/quiz/{quizId}', 
    callback: [$quizController, 'getQuiz'],
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'PUT', 
    path: '/quiz/{quizId}', 
    callback: [$quizController, 'updateQuiz'],
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'DELETE', 
    path: '/quiz/{quizId}', 
    callback: [$quizController, 'deleteQuiz'],
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'GET', 
    path: '/quiz', 
    callback: [$quizController, 'getAllQuizzes'],
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'POST', 
    path: '/quiz', 
    callback: [$quizController, 'createQuiz'],
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'GET', 
    path: '/played-quiz/{pquizId}', 
    callback: [$playedquizController, 'getPlayedQuiz'],
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'DELETE', 
    path: '/played-quiz/{pquizId}', 
    callback: [$playedquizController, 'deletePlayedQuiz'],
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'GET', 
    path: '/played-quiz', 
    callback: [$playedquizController, 'getAllPlayedQuizzes'],
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'GET', 
    path: '/question/{quizId}', 
    callback: [$questionController, 'getAllQuestions'],
    permissionCallback: true, 
    loginCallback: true
);

$router->addRoute(
    method: 'POST', 
    path: '/question/{quizId}', 
    callback: [$questionController, 'addQuestion'],
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'GET', 
    path: '/question/{quizId}/{questionId}', 
    callback: [$questionController, 'getQuestion'],
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'PUT', 
    path: '/question/{quizId}/{questionId}', 
    callback: [$questionController, 'updateQuestion'],
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'DELETE', 
    path: '/question/{quizId}/{questionId}', 
    callback: [$questionController, 'deleteQuestion'],
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'GET', 
    path: '/expo/{expoId}', 
    callback: [$expoController, 'getExpo'],
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'PUT', 
    path: '/expo/{expoId}', 
    callback: [$expoController, 'updateExpo'],
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'DELETE', 
    path: '/expo/{expoId}', 
    callback: [$expoController, 'deleteExpo'],
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'GET', 
    path: '/expo', 
    callback: [$expoController, 'getAllExpos'],
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'POST', 
    path: '/expo', 
    callback: [$expoController, 'createExpo'],
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'GET', 
    path: '/login', 
    callback: [$loginController, 'checkLoginState'],
    permissionCallback: true, 
    loginCallback: true
);

$router->addRoute(
    method: 'POST', 
    path: '/login', 
    callback: [$loginController, 'login'],
    permissionCallback: true, 
    loginCallback: true
);

$router->addRoute(
    method: 'GET', 
    path: '/logout', 
    callback: [$loginController, 'logout'],
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'GET',
    path: 'console/{consoleId}/info',
    callback: [$consoleApiController, 'getConsoleInfo'],
    permissionCallback: true,
    loginCallback: true,
);

$router->addRoute(
    method: 'POST',
    path: '/console/{consoleId}/start-quiz',
    callback: [$consoleApiController, 'startQuiz'],
    permissionCallback: true,
    loginCallback: true,
);

$router->addRoute(
    method: 'POST',
    path: '/console/{consoleId}/end-quiz',
    callback: [$consoleApiController, 'endQuiz'],
    permissionCallback: true,
    loginCallback: true,
);

$router->addRoute(
    method: 'GET',
    path: '/console/{consoleId}/didPlayerLogin/{joinLink}',
    callback: [$consoleApiController, 'didPlayerLogin'],
    permissionCallback: true,
    loginCallback: true,
);

$router->addRoute(
    method: 'GET',
    path: '/console/{consoleId}/quiz',
    callback: [$consoleApiController, 'getQuiz'],
    permissionCallback: true,
    loginCallback: true,
);

$router->dispatch();