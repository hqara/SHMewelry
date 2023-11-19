<?php

include_once "Controller.php";
include_once "../Models/User.php";

class UserController extends Controller{

    function route(){
        parent::route();

        $action = isset($_GET['action']) ? $_GET['action'] : "list";
		$id = isset($_GET['id']) ? intval($_GET['id']) : -1;

        if($action == "list"){
            $users = User::$action();

            $this->render("User", $action, $users);
        }
        else if ($action=="update" || $action=="save" || $action == "delete"){
           // $user = new User($id);
            $user->$action();
        }
        else if($action == "add"){
            $this->render("User", $action, array());
        }
        else{
            $user = new User($id);

            $this->render("User", $action, array($user));
        }
    }
}
    
?>