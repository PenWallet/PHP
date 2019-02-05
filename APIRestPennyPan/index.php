<?php

require_once "Request.php";
require_once "Response.php";
require_once "Authentication.php";

//Autoload rules
spl_autoload_register('apiAutoload');
function apiAutoload($classname)
{
    $res = false;

    //If the class name ends in "Controller", then try to locate the class in the controller directory to include it (require_once)
    if (preg_match('/[a-zA-Z]+Controller$/', $classname)) {
        if (file_exists(__DIR__ . '/controller/' . $classname . '.php')) {

            require_once __DIR__ . '/controller/' . $classname . '.php';
            $res = true;
        }
    } elseif (preg_match('/[a-zA-Z]+Model$/', $classname)) {
        if (file_exists(__DIR__ . '/model/' . $classname . '.php')) {

            require_once __DIR__ . '/model/' . $classname . '.php';

            $res = true;
        }
    }

    return $res;
}


//Let's retrieve all the information from the request
$verb = $_SERVER['REQUEST_METHOD'];

//IMPORTANT: WITH CGI OR FASTCGI, PATH_INFO WILL NOT BE AVAILABLE!!!
//SO WE NEED FPM OR PHP AS APACHE MODULE (UNSECURE, DEPRECATED) INSTEAD OF CGI OR FASTCGI
$path_info = !empty($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : (!empty($_SERVER['ORIG_PATH_INFO']) ? $_SERVER['ORIG_PATH_INFO'] : '');
$url_elements = explode('/', $path_info);

$query_string = null;
if (isset($_SERVER['QUERY_STRING'])) {
    parse_str($_SERVER['QUERY_STRING'], $query_string);
}
$body = file_get_contents("php://input");
if ($body === false) {
    $body = null;
}
$content_type = null;
if (isset($_SERVER['CONTENT_TYPE'])) {
    $content_type = $_SERVER['CONTENT_TYPE'];
}
$accept = null;
if (isset($_SERVER['HTTP_ACCEPT'])) {
    $accept = $_SERVER['HTTP_ACCEPT'];
}
$token = null; $authUser = null; $authPass = null;
if(isset($_SERVER['HTTP_AUTHORIZATION']))
{
    if(explode(" ", $_SERVER['HTTP_AUTHORIZATION'])[0] == "Bearer")
    {
        $token = explode(" ", $_SERVER['HTTP_AUTHORIZATION'])[1];
    }
    else if(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']))
    {
        $authUser = $_SERVER['PHP_AUTH_USER'];
        $authPass = $_SERVER['PHP_AUTH_PW'];
    }
}

$req = new Request($verb, $url_elements, $query_string, $body, $content_type, $accept, $authUser, $authPass, $token);

// route the request to the right place
if(isset($url_elements[3]))
    $controller_name = ucfirst($url_elements[3]) . 'Controller';
else
    $controller_name = ucfirst($url_elements[1]) . 'Controller';

$newToken = Authentication::isAuthenticated($req);
$req->setToken($newToken);

if($newToken !== false || ($newToken === false && ($controller_name == "PanController" || $controller_name == "ComplementoController" || $controller_name == "IngredienteController")) || ($verb == "POST" && $controller_name == "ClienteController"))
{
    if (class_exists($controller_name))
    {
        $controller = new $controller_name();
        $action_name = 'manage' . ucfirst(strtolower($verb)) . 'Verb';
        $controller->$action_name($req);
    } //If class does not exist, we will send the request to NotFoundController
    else
    {
        $controller = new NotFoundController();
        $controller->manage($req); //We don't care about the HTTP verb
    }
}
else
{
    $controller = new UnauthorizedController();
    $controller->manage($req);
}


