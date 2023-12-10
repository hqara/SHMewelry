<?php

include_once __DIR__ . "/../Controllers/Controller.php";
include_once __DIR__ . "/../Models/User.php"; // DON'T REMOVE THIS

class HomeController extends Controller {

    function route() {
        parent::route(); 
    
        $action = isset($_GET['action']) ? $_GET['action'] : "index";
    
        if ($action == "support") {
            $this->render('Home', 'support', []);
        } else {
            $this->render('Home', 'index', []);
        }
    }
}

?>
