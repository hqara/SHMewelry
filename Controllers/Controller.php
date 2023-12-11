<?php

class Controller{

    function validateSessionUser() {
        return;
//		if(!isset($_SESSION['user']))
//			header("Location: ?controller=login");
    }
	
	function route() {
		$this->validateSessionUser();
       // global $controller, $view;
        //$this->render($controller, $view);
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