<?php

include_once __DIR__ . "/Controller.php";
include_once __DIR__ . "/../Models/Product.php";

class ProductController extends Controller{

    function route(){
        parent::route();

        $action = isset($_GET['action']) ? $_GET['action'] : "list";
		$id = isset($_GET['id']) ? intval($_GET['id']) : -1;

        if($action == "list"){
            $products = Product::$action();

            $this->render("Product", $action, array($product));
        }
        else if ($action=="update" || $action=="create" || $action == "delete"){ 
            $product = new Product($id);
            $product->$action();
        }
        else if($action == "add"){
            $this->render("Product", $action, array());
        }
        else{ // edit and remove
            $product = new Product($id);

            $this->render("Product", $action, array($product));
        }


    }
}



?>
