<?php

include_once __DIR__ . "/../Models/User.php";

class Controller{

    function validateSessionUser() {
        /*
        session_start();  // Start or resume the session
    
        if (!isset($_SESSION['user'])) {
            header("Location: ?controller=home&action=index");
            exit();
        } else {

        }
        */
    }
    
	function route() {
        $this->validateSessionUser();
    
        /*
        // Validate controller and action names to prevent possible security issues
        $allowedControllers = ['Home', 'Product', 'Address', 'Orders', 'User'];
        $allowedActions = ['index', 'list', 'read', 'cart', 'create', 'update', 'delete', 'login', 'logout', 'add', 'edit'];
    
        if (!in_array($controllerName, $allowedControllers) || !in_array($actionName, $allowedActions)) {
            // Invalid controller or action, handle accordingly (redirect, show 404, etc.)
            $this->render('Error', 'index');
            return;
        }
    
        // Construct the controller class name
        $controllerClassName = ucfirst($controllerName) . 'Controller';
    
        // Include the controller file
        include_once __DIR__ . "/../Controllers/$controllerClassName.php";
    
        // Create an instance of the controller
        $controller = new $controllerClassName();
    
        // Call the specified action on the controller
        $controller->$actionName();
        */
    }

    /*
    
	function route() {
		$this->validateSessionUser();
       // global $controller, $view;
        //$this->render($controller, $view);
	}

    */

    protected function userIsLoggedIn() {
        return isset($_SESSION['user']);
    }


    function render($controller, $action, $data = []) {
        //extract($data);
        $dirString = dirname(__FILE__) . "/../Views/$controller/{$action}.php";
        
        if (file_exists($dirString))
        {
            include_once $dirString;
        }
        else
        {
            var_dump($dirString);
            include_once dirname(__FILE__) . "/../404.php";
           
        }
    }
}

?>