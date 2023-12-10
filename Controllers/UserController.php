<?php

include_once __DIR__ . "/Controller.php";
include_once __DIR__ . "/../Models/User.php";

class UserController extends Controller {
    
    function route() {
        parent::route();

        $action = isset($_GET['action']) ? $_GET['action'] : "list";
        $id = isset($_GET['id']) ? intval($_GET['id']) : -1;

        // Initialize the User model
        $userModel = new User();

        if ($action == "list" || $action == "read") {
            $users = User::$action();
            $this->render("User", $action, $users);
        } else if ($action == "create" || $action == "update" || $action == "delete") {
            $result = $userModel->$action();
        } else if ($action == "updateEmail" || $action == "updatePassword") {
            $result = $this->handleUpdateAction($userModel);
        } else if ($action == "add") {
            $this->render("User", $action, array());
        } else {
            $user = new User($id);
            $this->render("User", $action, array('user' => $user));
        }
    }

    
    private function handleUpdateAction($userModel) {
        if (isset($_POST['updateEmail'])) {
            return $userModel->updateEmail();
        } elseif (isset($_POST['updatePassword'])) {
            return $userModel->updatePassword();
        }

        return false;
    }
}
?>
