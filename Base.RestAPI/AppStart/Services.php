<?php

// /**
//  * Read the configuration
//  */
$config = new Phalcon\Config\Adapter\Ini(__DIR__ . '/Config.ini');
/**
* The DI is our direct injector.  It will store pointers to all of our services
* and we will insert it into all of our controllers.
* @var DefaultDI
*/
$di = new Phalcon\DI\FactoryDefault();
/**
* Return array of the Collections, which define a group of routes, from
* routes/collections.  These will be mounted into the app itself later.
*/
$di->set('collections', function () {
    return include ('./Routes/RouteLoader.php');
});
// As soon as we request the session service, it will be started.
$di->setShared('session', function () {
    $session = new \Phalcon\Session\Adapter\Files();
    $session->start();
    $session->set('language', 'id');
    return $session;
});
$di->set('modelsCache', function () {
    
    //Cache data for one day by default
    $frontCache = new \Phalcon\Cache\Frontend\Data(array('lifetime' => 3600));
    
    //File cache settings
    $cache = new \Phalcon\Cache\Backend\File($frontCache, array('cacheDir' => __DIR__ . '/Cache/'));
    
    return $cache;
});
/**
* Database connection is created based in the parameters defined in the configuration file
*/
$di->set('db', function () use ($config) {
    try {
        $eventsManager = new Phalcon\Events\Manager();
        $logger = new Phalcon\Logger\Adapter\File("debug.log");
        $eventsManager->attach('db', function ($event, $connection) use ($logger) {

            if ($event->getType() == 'beforeQuery') {
                $logger->log($connection->getSQLStatement(), Phalcon\Logger::INFO);
            }
        });
        $dbclass = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;

        $connection = new $dbclass(array(
        "host" => $config->database->host,
        "username" => $config->database->username,
        "password" => $config->database->password,
        "dbname" => $config->database->name));

        $connection->setEventsManager($eventsManager);

        return $connection;
     } catch (Exception $e) {
        die("<b>Error when initializing database connection:</b> " . $e->getMessage());
    }
});
/**
* If our request contains a body, it has to be valid JSON.  This parses the
* body into a standard Object and makes that vailable from the DI.  If this service
* is called from a function, and the request body is nto valid JSON or is empty,
* the program will throw an Exception.
*/
$di->setShared('requestBody', function () {
    $in = file_get_contents('php://input');
    $in = json_decode($in, FALSE);
    
    // JSON body could not be parsed, throw exception
    if ($in === null) {
        throw new \Base\Framework\Exceptions\HTTPException('There was a problem understanding the data sent to the server by the application.', 409, array('dev' => 'The JSON body sent to the server was unable to be parsed.', 'internalCode' => 'REQ1000', 'more' => ''));
    }
    
    return $in;
});

// /**
//  * MVC dispatcher
//  */
// $di->set('dispatcher', function () {

//     $eventsManager = new \Phalcon\Events\Manager();

//     /**
//      * Check if the user is allowed to access certain action using the SecurityPlugin
//      */
//     $eventsManager->attach('dispatch:beforeDispatch', new SecurityPlugin);

//     /**
//      * Handle exceptions and not-found exceptions using NotFoundPlugin
//      */
//     $eventsManager->attach('dispatch:beforeException', new NotFoundPlugin);

//     $dispatcher = new Dispatcher;
//     $dispatcher->setEventsManager($eventsManager);

//     return $dispatcher;
// });

/**
* Out application is a Micro application, so we mush explicitly define all the routes.
* For APIs, this is ideal.  This is as opposed to the more robust MVC Application
* @var $app
*/
$app = new Phalcon\Mvc\Micro();
/**
* Set dependency injection
*/
$app->setDI($di);
/**
* Before every request, make sure user is authenticated.
* Returning true in this function resumes normal routing.
* Returning false stops any route from executing.
*/
/*
This will require changes to fit your application structure.
It supports Basic Auth, Session auth, and Exempted routes.
It also allows all Options requests, as those tend to not come with
cookies or basic auth credentials and Preflight is not implemented the
same in every browser.
*/

$app->before(function() use ($app, $di) {

    //return true;
    // Browser requests, user was stored in session on login, replace into DI
    if ($di->getShared('session')->get('auth') != false) {
        $di->setShared('user', function() use ($di){
            return $di->getShared('session')->get('auth');
        });
        return true;
    }

    //var_dump($app->request->getServer('PHP_AUTH_USER'));
    // Basic auth, for programmatic responses
    if($app->request->getServer('PHP_AUTH_USER')){
        $user = new \Base\Controllers\Configurations\UserController();
        $user->login(
            $app->request->getServer('PHP_AUTH_USER'),
            $app->request->getServer('PHP_AUTH_PW')
        );
        return true;
    }

    // All options requests get a 200, then die
    if($app->__get('request')->getMethod() == 'OPTIONS'){
        $app->response->setStatusCode(200, 'OK')->sendHeaders();
        exit;
    }

    // Exempted routes, such as login, or public info.  Let the route handler
    // pick it up.
    switch($app->getRouter()->getRewriteUri()){
        case '/api/user/login':
            return true;
            break;
        case '/api/resource/':
            return true;
            break;
        case '/api/translation/search':
            return true;
            break;
        case '/api/donor/createOrLoad':
            return true;
            break;
        case '/api/donation/confirm':
            return true;
            break;
    }
    // If we made it this far, we have no valid auth method, throw a 401.
    throw new \Base\Framework\Exceptions\HTTPException(
        'Must login or provide credentials.',
        401,
        array(
            'dev' => 'Please provide credentials by either passing in a session token via cookie, or providing password and username via BASIC authentication.',
            'internalCode' => 'Unauth:1'
        )
    );
    return false;
});
/**
* Mount all of the collections, which makes the routes active.
*/
foreach ($di->get('collections') as $collection) {
    $app->mount($collection);
}
/**
* The base route return the list of defined routes for the application.
* This is not strictly REST compliant, but it helps to base API documentation off of.
* By calling this, you can quickly see a list of all routes and their methods.
*/
$app->get('/', function () use ($app) {
    $routes = $app->getRouter()->getRoutes();
    $routeDefinitions = array(
        'GET' => array() ,
        'POST' => array() ,
        'PUT' => array() ,
        'PATCH' => array() ,
        'DELETE' => array() ,
        'HEAD' => array() ,
        'OPTIONS' => array()
    );
    foreach ($routes as $route) {
        $method = $route->getHttpMethods();
        $routeDefinitions[$method][] = $route->getPattern();
    }
    return $routeDefinitions;
});
/**
* After a route is run, usually when its Controller returns a final value,
* the application runs the following function which actually sends the response to the client.
*
* The default behavior is to send the Controller's returned value to the client as JSON.
* However, by parsing the request querystring's 'type' paramter, it is easy to install
* different response type handlers.  Below is an alternate csv handler.
*/
$app->after(function () use ($app) {
    
    // OPTIONS have no body, send the headers, exit
    if ($app->request->getMethod() == 'OPTIONS') {
        $app->response->setStatusCode('200', 'OK');
        $app->response->send();
        return;
    }
    
    // Respond by default as JSON
    if (!$app->request->get('type') || $app->request->get('type') == 'json') {
        
        // Results returned from the route's controller.  All Controllers should return an array
        $records = $app->getReturnedValue();
        
        $response = new \Base\Framework\Responses\JSONResponse();
        $response->useEnvelope(true)
        
        //this is default behavior
        ->convertSnakeCase(false)
        
        //this is also default behavior
        ->send($records);
        
        return;
    }
    else if ($app->request->get('type') == 'csv') {
        
        $records = $app->getReturnedValue();
        $response = new \Base\Framework\Responses\CSVResponse();
        $response->useHeaderRow(true)->send($records);
        
        return;
    }
    else {
        throw new \Base\Framework\Exceptions\HTTPException('Could not return results in specified format', 403, array(
            'dev' => 'Could not understand type specified by type paramter in query string.',
            'internalCode' => 'NF1000',
            'more' => 'Type may not be implemented. Choose either "csv" or "json"'
        ));
    }
});
/**
* The notFound service is the default handler function that runs when no route was matched.
* We set a 404 here unless there's a suppress error codes.
*/
$app->notFound(function () use ($app) {
    throw new \Base\Framework\Exceptions\HTTPException('Not Found.', 404, array(
        'dev' => 'That route was not found on the server.',
        'internalCode' => 'NF1000',
        'more' => 'Check route for mispellings.'
    ));
});
/**
* If the application throws an HTTPException, send it on to the client as json.
* Elsewise, just log it.
* TODO:  Improve this.
*/
set_exception_handler(function ($exception) use ($app) {
    
    //HTTPException's send method provides the correct response headers and body
    if (is_a($exception, 'Base\\Framework\\Exceptions\\HTTPException')) {
        $exception->send();
    }
    error_log($exception);
    error_log($exception->getTraceAsString());
});
