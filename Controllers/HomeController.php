<?php

include_once __DIR__ . "/../Controllers/Controller.php";
include_once __DIR__ . "/../Models/User.php";
//include_once __DIR__ . "/../Models/Products.php";

class HomeController extends Controller {

    function route() {
        parent::route(); // Call the route method of the parent Controller class
        
        global $view;

        $data = [
            'message' => 'Welcome to the home page!',
            // Add other data as needed
        ];


        // view validation
        if ($view == "list")
        {
            $this->render('Home', $view, $data);

        }
        else
        {
            $this->render('Home', 'index', $data);

        }
    }
        
        // You can add other methods specific to the HomeController if needed
    

        /*

        under work 
        $data = [];
        $action = isset($_GET['action']) ? $_GET['action'] : "index";
        $id = isset($_GET['id']) ? intval($_GET['id']) : -1;
        
           // Initialize the User model (session)
           $userModel = new User();
           $productModel = new Product();

           if ($action == "index") {
            $this->render("Home", $action, $data);
           }
           else if ($action == "list" || $action == "view") {
               $products = Ps::$action();
               $this->render("Orders", $action, $orders);
           } else if ($action == "register" || $action == "update" || $action == "delete") {
               $result = $orderModel->$action();
           } else if ($action == "add") {
               $this->render("Orders", $action, array());
           } else {
               $order = new Orders($id);
               $this->render("Orders", $action, array('order' => $order));
           }
    }  
    
    */
}

?>
