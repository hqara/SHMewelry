<?php

include_once __DIR__ . "/Controller.php";
include_once __DIR__ . "/../Models/Address.php";

class AddressController extends Controller {
    
    function route() {
        parent::route();

        $action = isset($_GET['action']) ? $_GET['action'] : "list";
        $id = isset($_GET['id']) ? intval($_GET['id']) : -1;

        // Initialize the Address model
        $addressModel = new Address();

        if ($action == "list") {
            $addresss = Address::$action();
            $this->render("Address", $action, $addresses);
        } else if ($action == "create" || $action == "update") {
            $result = $addressModel->$action();
        } else if ($action == "add") {
            $this->render("Address", $action, array());
        } else {
            $address = new Address($id);
            $this->render("Address", $action, array('address' => $address));
        }
    }
}
?>
