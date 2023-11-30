<?php

include_once __DIR__ . "/Controller.php";
include_once __DIR__ . "/../Models/Login.php";

class LoginController extends Controller {

    function route() {
        parent::route(); // Call the route method of the parent Controller class

        $action = isset($_GET['action']) ? $_GET['action'] : "login";
        $id = isset($_GET['id']) ? intval($_GET['id']) : -1;

        $loginModel = new Login(); 
        $data = []; // Define $data here

        // Call the login or register method based on the action
        if ($action == "login") {
            $loginModel->$action(); 
            $this->render('Login', $action, $data);  
        } else if ($action == "create" || $action == "update") {
            $result = $loginModel->$action();
        } elseif ($action == "register"|| $action == "reset") {
            $this->render("Login", $action, array());
        } else {
            $login = new Login($id);
            $this->render("Login", $action, array('login' => $login));
        }
    }
}

?>
