<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


$controller = (isset($_GET['controller'])) ? $_GET['controller'] : "home";

$controllerClassName = ucfirst($controller) . "Controller";
include_once __DIR__ . "/Controllers/$controllerClassName.php";
//var_dump($controllerClassName);
$ct = new $controllerClassName();
$ct->route();

?>
