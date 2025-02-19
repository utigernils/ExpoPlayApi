<?php
require_once 'handlers/config.php';
require_once 'handlers/router.php';
require_once 'handlers/session.php';
require_once 'handlers/db.php';

require_once 'controllers/userController.php';

$config = new Config(configPath:
    'config.ini'
);

$router = new Router(
    contentType: $config->get('content_type'),
    basePath:$config->get('base_path')
);

$session = new Session();

$db = new db(
    host:$config->get('db_host'), 
    db:$config->get('db_name'),
    user: $config->get('db_user'), 
    pass:$config->get('db_pass')
);

$userController = new DashboardUser_crtl($session);

#helper functions
function getUser() {
    echo 'it works';
}

$router->addRoute(
    method: 'GET', 
    path: '/user/{userId}', 
    callback: 'getUser',
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);  

$router->addRoute(
    method: 'PUT', 
    path: '/user/{userId}', 
    callback: 'updateUser',
    permissionCallback: [$session, 'checkAdmin'], 
    loginCallback: [$session, 'checkLogin']
);  

$router->addRoute(
    method: 'DELETE', 
    path: '/user/{userId}', 
    callback: 'deleteUser',
    permissionCallback: [$session, 'checkAdmin'], 
    loginCallback: [$session, 'checkLogin']
);  

$router->addRoute(
    method: 'GET', 
    path: '/user', 
    callback: 'getUser',
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'POST', 
    path: '/user', 
    callback: 'registerUser',
    permissionCallback: [$session, 'checkAdmin'], 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'GET', 
    path: '/console/{consoleId}', 
    callback: 'getConsole',
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'PUT', 
    path: '/console/{consoleId}', 
    callback: 'updateConsole',
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'DELETE', 
    path: '/console/{consoleId}', 
    callback: 'unlinkConsole',
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'GET', 
    path: '/console', 
    callback: 'getAllConsoles',
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'POST', 
    path: '/console', 
    callback: 'registerConsole',
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'GET', 
    path: '/player/{playerId}', 
    callback: 'getPlayer',
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'PUT', 
    path: '/player/{playerId}', 
    callback: 'updatePlayer',
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'DELETE', 
    path: '/player/{playerId}', 
    callback: 'removePlayer',
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'GET', 
    path: '/player', 
    callback: 'getAllPlayers',
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'GET', 
    path: '/quiz/{quizId}', 
    callback: 'getQuiz',
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'PUT', 
    path: '/quiz/{quizId}', 
    callback: 'updateQuiz',
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'DELETE', 
    path: '/quiz/{quizId}', 
    callback: 'deleteQuiz',
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'GET', 
    path: '/quiz', 
    callback: 'getAllQuizzes',
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'POST', 
    path: '/quiz', 
    callback: 'createQuiz',
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'GET', 
    path: '/played-quiz/{pquizId}', 
    callback: 'getPlayedQuiz',
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'DELETE', 
    path: '/played-quiz/{pquizId}', 
    callback: 'deletePlayedQuiz',
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'GET', 
    path: '/played-quiz', 
    callback: 'getAllPlayedQuizzes',
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'GET', 
    path: '/question/{quizId}', 
    callback: 'getAllQuestions',
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'POST', 
    path: '/question/{quizId}', 
    callback: 'addQuestion',
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'GET', 
    path: '/question/{quizId}/{questionId}', 
    callback: 'getQuestion',
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'PUT', 
    path: '/question/{quizId}/{questionId}', 
    callback: 'updateQuestion',
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'DELETE', 
    path: '/question/{quizId}/{questionId}', 
    callback: 'deleteQuestion',
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'GET', 
    path: '/expo/{expoId}', 
    callback: 'getExpo',
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'PUT', 
    path: '/expo/{expoId}', 
    callback: 'updateExpo',
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'DELETE', 
    path: '/expo/{expoId}', 
    callback: 'deleteExpo',
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'GET', 
    path: '/expo', 
    callback: 'getAllExpos',
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'POST', 
    path: '/expo', 
    callback: 'createExpo',
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->addRoute(
    method: 'GET', 
    path: '/login', 
    callback: 'checkLoginState',
    permissionCallback: true, 
    loginCallback: true
);

$router->addRoute(
    method: 'POST', 
    path: '/login', 
    callback: [$userController, 'login'],
    permissionCallback: true, 
    loginCallback: true
);

$router->addRoute(
    method: 'GET', 
    path: '/logout', 
    callback: [$userController, 'logout'],
    permissionCallback: true, 
    loginCallback: [$session, 'checkLogin']
);

$router->dispatch();