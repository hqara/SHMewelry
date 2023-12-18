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
            } elseif (in_array($action, ["create", "update", "delete", "deleteAccount","bag", "unbag", "updateQty", "clear"])) {
                $result = $userModel->$action();
            } elseif (in_array($action, ["updatePassword"])) {
                $result = $this->updatePassword();
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
    public function updatePassword() {
        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and sanitize the input data
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $newPassword = filter_input(INPUT_POST, 'passwordInput', FILTER_SANITIZE_STRING);

            // Check if both email and password are provided
            if (!empty($email) && !empty($newPassword)) {
                // Update the user's password in the model
                $userModel = new User(); // Replace $yourDatabaseConnection with your actual database connection

                if ($userModel->updatePassword($email, $newPassword)) {
                    // Password update successful
                    // Redirect to a success page or back to the profile page
                header('Location: index.php?controller=user&action=read');
                    exit();
                } else {
                    // Password update failed
                    // You might want to display an error message or redirect back to the form with an error
                    echo "Failed to update password.";
                }
            } else {
                // Handle validation errors
                // You might want to display an error message or redirect back to the form with an error
                echo "Invalid input. Both email and password are required.";
            }
        }
    }
}
?>
