<?php

include_once __DIR__ . "/Controller.php";
include_once __DIR__ . "/../Models/Product.php";

class ProductController extends Controller {

    function route() {
        parent::route();

        $action = isset($_GET['action']) ? $_GET['action'] : "list";
        $id = isset($_GET['id']) ? intval($_GET['id']) : -1;

        // Initialize the Product model
        $productModel = new Product();

        if ($action == "list" || $action == "view" || $action == "read") {
            $products = $productModel->$action();
            if (!empty($products)) {
                $this->render("Product", $action, $products);
            } else {
                $this->render("Product", $action, array());
            }
        } else if ($action == "create" || $action == "update" || $action == "delete") {
            $result = $productModel->$action();
        } else if ($action == "add") {
            $this->render("Product", $action, array());
        } else {
            $product = new Product($id);
            $this->render("Product", $action, array('product' => $product));
        }
    }
}
?>
