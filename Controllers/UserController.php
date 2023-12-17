<?php

include_once __DIR__ . "/Controller.php";
include_once __DIR__ . "/../Models/User.php";

class UserController extends Controller {
    
    public function route() {
        parent::route();

        $action = isset($_GET['action']) ? $_GET['action'] : "list";
        $id = isset($_GET['id']) ? intval($_GET['id']) : -1;
        $userModel = new User();

 
            if ($action == "login") {
                if ($this->userIsLoggedIn()) {
                    $this->render("Home", "index");
                } else {
                $this->handleLoginAction();
                } 
            } elseif ($action == "logout") {
                $users = User::$action();
            } elseif ($action == "register") {
                $this->handleRegisterAction($userModel);
                $_SESSION['register_alert'] = "";
            } elseif ($action == "reset") {
                $this->handleResetAction($userModel);
                $_SESSION['reset_alert'] = "";
            } elseif (in_array($action, ["list", "read", "cart"])) {
                $users = User::$action();
                $this->render("User", $action, $users);
            } elseif (in_array($action, ["create", "update", "delete", "deleteAccount","bag", "unbag", "updateQty", "unbagAll"])) {
                $result = $userModel->$action();
            } elseif (in_array($action, ["updateEmail", "updatePassword"])) {
                $result = $this->handleUpdateAction($userModel);
            } elseif ($action == "add") {
                $this->render("User", $action, array());
            } else {
                $user = new User($id);
                $this->render("User", $action, array('user' => $user));
            }
        }

    private function handleLoginAction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $users = User::login();
            if ($this->userIsLoggedIn()) {
                $this->render("Home", "index");
            } else {
                $this->render("User", "login", null);
            }
        } else {
            $this->render("User", "login");
        }
    }

    private function handleRegisterAction($userModel) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $userModel->register();
            if ($result === true) {
                header('Location: index.php?controller=user&action=login');
                exit();
            } else {
                $_SESSION['register_alert'] = "Registration failed: " . $result;
                $this->render("User", "register");
            }
        } else {
            $this->render("User", "register");
        }
    }

    private function handleResetAction($userModel) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['reset_alert'] = "";
            $result = $userModel->reset();
            if ($result === true) {
                header('Location: index.php?controller=user&action=login');
                exit();
            } else {
                $_SESSION['reset_alert'] = $result;
            }
        }
        // Render the "reset" view only once
        $this->render("User", "reset");
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
