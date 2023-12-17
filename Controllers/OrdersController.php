<?php

include_once __DIR__ . "/Controller.php";
include_once __DIR__ . "/../Models/Orders.php";


class OrdersController extends Controller {
    
    function route() {
        parent::route();

        $action = isset($_GET['action']) ? $_GET['action'] : "list";
        $id = isset($_GET['id']) ? intval($_GET['id']) : -1;

        // Initialize the Orders model
        $orderModel = new Orders();
        if ($this->userIsLoggedIn() && $action == "list") {
            $orders = Orders::$action();
            $this->render("Orders", $action, $orders);

        }else if ($action == "view") {
            $orders = Orders::$action();
             $this->render("Orders", $action, $orders);
        } else if ($action == "create" || $action == "update" || $action == "delete" || $action == "deleteOrder") {
            $result = $orderModel->$action();
        } else if ($action == "add") {
            $this->render("Orders", $action, array());
        } else {
            $order = new Orders($id);
            $this->render("Orders", $action, array('order' => $order));
        }
    }
}

?>