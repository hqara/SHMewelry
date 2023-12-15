<?php


$controller = isset($_GET['controller']) ? $_GET['controller'] : "home";
$action = isset($_GET["action"]) ? $_GET["action"] : "index";

$controller = ucfirst($controller);
$controllerClassName = $controller . "Controller";
$controllerPath = __DIR__ . "/Controllers/$controllerClassName.php";

// so it doesn't include the parent controller class
if (file_exists($controllerPath) && $controller != "") 
{
    include_once $controllerPath;
    $ct = new $controllerClassName();
    $ct->route();
}
else
{
    include_once "404.php";
}

?>
