<?php

class Controller{

    function validateSessionUser() {
        return;
//		if(!isset($_SESSION['user']))
//			header("Location: ?controller=login");

    }
	
	function route(){
		$this->validateSessionUser();

	}

    function render($controller, $view, $data = []) {
        extract($data);

        include "Views/$controller/$view.php";
    }
}

?>