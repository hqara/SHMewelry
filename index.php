<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$controller = isset($_GET['controller']) ? $_GET['controller'] : "home";
$action = isset($_GET["action"]) ? $_GET["action"] : "index";

$controller = ucfirst($controller);
$controllerClassName = $controller . "Controller";
$controllerPath = __DIR__ . "/Controllers/$controllerClassName.php";

if (file_exists($controllerPath) && $controller != "") // so it doesn't include the parent controller class
{
    include_once $controllerPath;
    //var_dump($controllerClassName);
    $ct = new $controllerClassName();
    $ct->route();
}
else
{
    include_once "404.php";
}

?>
