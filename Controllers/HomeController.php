<?php

include_once __DIR__ . "/../Controllers/Controller.php";
include_once __DIR__ . "/../Models/User.php";

class HomeController extends Controller {

    function route() {
        parent::route();

            //temporary
            include_once __DIR__ . "/../Views/Home/index.php";
    }
}
?>
