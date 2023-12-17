<?php

include_once __DIR__ . "/../Models/User.php";

class Controller {

    
    function validateSessionUser($controller, $action) {
        if ($this->hasRights($controller, $action)) {
            $this->render($controller, $action);
        } else {
            $this->render("Home", "index");
        }
    }

    protected function userIsLoggedIn() {
        return isset($_SESSION['user']);
    }

    protected function groupId() {
        return isset($_SESSION['user']->group_id);
    }

    protected function userId() {
        return isset($_SESSION['user']->user_id);
    }

    function render($controller, $action, $data = []) {
        $dirString = dirname(__FILE__) . "/../Views/$controller/{$action}.php";

        if (file_exists($dirString)) {
            include_once $dirString;
        } else {
            var_dump($dirString);
            include_once dirname(__FILE__) . "/../404.php";
        }
    }

    function route() {
        //NEED TO FIX DATABASE
        //$this->validateSessionUser($controller, $action);
    }

    public function hasRights($classname, $action) {
        global $conn;

        $user_id = isset($_SESSION['user']) ? $_SESSION['user']->user_id : -1;

        // Using prepared statements to prevent SQL injection
        $sql = "SELECT rights.RIGHTS_ID, rights.ACTION_NAME, rights.CLASS_NAME FROM `user` 
                INNER JOIN `group` USING (`GROUP_ID`) 
                INNER JOIN group_rights ON (group.GROUP_ID = group_rights.GROUP_ID) 
                INNER JOIN rights ON (group_rights.RIGHTS_ID = rights.RIGHTS_ID) 
                WHERE rights.ACTION_NAME LIKE ? AND rights.CLASS_NAME LIKE ? AND user.USER_ID = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $action, $classname, $user_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $r = $res->fetch_assoc();

        return ($r !== null);
    }
}

?>
