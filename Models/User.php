<?php

include_once(__DIR__ . '/../db_connection.php');

class User
{

    public $user_id;
    public $fname;
    public $lname;
    public $email;
    public $password;
    public $group_id;

    public function __construct($id = -1)
    {
        
        global $conn;

        if ($id > 0) {
            // fetch user details from the database
            $sql = "SELECT * FROM `USER` WHERE USER_ID = ?";
            $stmt = $conn->prepare($sql);

            // Check if the prepared statement was successful
            if (!$stmt) {
                throw new Exception("Error preparing statement: " . $conn->error);
            }

            $stmt->bind_param('i', $id);
            $stmt->execute();
            $res = $stmt->get_result();

            // Check if the execution was successful
            if (!$res) {
                throw new Exception("Error executing statement: " . $stmt->error);
            }

            // Check if there are rows returned
            if ($res->num_rows > 0) {
                // Fetch the associative array representing the user
                $assocUser = $res->fetch_assoc();

                // set object properties
                $this->user_id = $id;
                $this->fname = $assocUser['FNAME'];
                $this->lname = $assocUser['LNAME'];
                $this->email = $assocUser['EMAIL'];
                $this->password = $assocUser['PASSWORD'];
                $this->group_id = $assocUser['GROUP_ID'];

                $stmt->close();
            } else {
                // If no rows are found, set default values
                $this->user_id = -1;
                $this->fname = "";
                $this->lname = "";
                $this->email = "";
                $this->password = "";
                $this->group_id = 0;
            }
        } else {
            // If $id is not a positive integer, set default values
            $this->user_id = -1;
            $this->fname = "";
            $this->lname = "";
            $this->email = "";
            $this->password = "";
            $this->group_id = 0;
        }
    }

     public function updatePassword($email, $newPassword) {
        // Update the user's password in the database
        // Make sure to use prepared statements to prevent SQL injection
        global $conn;
        $this->conn = $conn;
        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Prepare and execute the update statement
        $stmt = $this->conn->prepare("UPDATE user SET password = ? WHERE email = ?");
        $stmt->bind_param('ss', $hashedPassword, $email);

        if ($stmt->execute()) {
            return true; // Update successful
        } else {
            // Handle the error. You might want to log it or return false to indicate failure.
            return false;
        }
    }

    public static function list()
    {
        global $conn;

        $sql = 'SELECT USER.USER_ID, USER.FNAME, USER.LNAME, USER.EMAIL, USER.GROUP_ID, `GROUP`.GROUP_NAME
                FROM USER INNER JOIN `GROUP` 
                ON USER.GROUP_ID = `GROUP`.GROUP_ID';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function read()
    {
        global $conn;

        // Check if user ID is present in the session
        $userId = isset($_SESSION['user']) ? $_SESSION['user']->user_id : null;

        $sql = "SELECT * FROM `USER` WHERE USER_ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $userId);

        $stmt->execute();
        $result = $stmt->get_result();

        // Return the fetched result
        return $result->fetch_assoc();
    }


    public function register()
{
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Collect user input data
        $firstName = $_POST['fname'];
        $lastName = $_POST['lname'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Validate input data and register user
        if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
            $_SESSION['register_alert'] = "All fields are required.";
            header('Location: index.php?controller=user&action=register'); // Redirect back to registration page
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['register_alert'] = "Invalid email format.";
            header('Location: index.php?controller=user&action=register'); // Redirect back to registration page
            exit();
        }

        // Additional password validation
        if (strlen($password) < 7 || !preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
            $_SESSION['register_alert'] = "Password must be at least 7 characters long, contain at least one capital letter, and one number.";
            header('Location: index.php?controller=user&action=register'); // Redirect back to registration page
            exit();
        }

        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare database query
        $query = 'INSERT INTO user (fname, lname, email, password, group_id) VALUES (?, ?, ?, ?, 1)';
        try {
            if ($stmt = $conn->prepare($query)) {
                // Bind parameters
                $stmt->bind_param("ssss", $firstName, $lastName, $email, $hashedPassword);

                // Execute query and check for successful insertion
                if ($stmt->execute()) {
                    // Registration successful
                    $_SESSION['register_alert'] = "Registration successful!";
                    header('Location: index.php?controller=user&action=login'); // Redirect to login page
                    exit();
                } else {
                    // Handle errors, e.g., duplicate entry
                    $_SESSION['register_alert'] = "Email already in use.";
                    header('Location: index.php?controller=user&action=register'); // Redirect back to registration page
                    exit();
                }
            } else {
                // Handle preparation error
                $_SESSION['register_alert'] = "An error occurred during query preparation: " . $conn->error;
                header('Location: index.php?controller=user&action=register'); // Redirect back to registration page
                exit();
            }
        } catch (mysqli_sql_exception $exception) {
            // Handle other exceptions
            $_SESSION['register_alert'] = "An unexpected error occurred: " . $exception->getMessage();
            header('Location: index.php?controller=user&action=register'); // Redirect back to registration page
            exit();
        }
    }
}


    public static function login()
    {
        global $conn;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Use prepared statements to prevent SQL injection
            $query = "SELECT user_id, email, password, fname, lname, group_id FROM user WHERE email = ?";
            $stmt = $conn->prepare($query);

            if ($stmt) {
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();

                    // Use password_verify to check hashed password
                    if (password_verify($password, $row['password'])) {
                        // User logged in
                        $user = new User();
                        $user->user_id = $row['user_id'];
                        $user->fname = $row['fname'];
                        $user->lname = $row['lname'];
                        $user->email = $row['email'];
                        $user->password = $row['password'];
                        $user->group_id = $row['group_id'];

                        // Store user object in session
                        $_SESSION['user'] = $user;
                        header('Location: index.php?controller=home&action=index');
                        exit();
                    } else {
                        // Incorrect password
                        $_SESSION['login_alert'] = "Invalid email or password";
                    }
                } else {
                    // User not found
                    $_SESSION['login_alert'] = "Invalid email or password";
                }
            } else {
                // Handle the case where there's an issue with the prepared statement
                $_SESSION['login_alert'] = "An error occurred. Please try again later.";
            }

            // Redirect to the login page if the login attempt fails
            header('Location: index.php?controller=user&action=login');
            exit();
        }
    }

    public function reset()
    {
        global $conn;

        // Check if the 'reset' key is set in the POST data
        if (isset($_POST['reset'])) {
            // Check if the required keys are present in the POST data
            if (isset($_POST['email'], $_POST['password'])) {
                // Validate input data and reset password
                $email = $_POST['email'];
                $password = $_POST['password'];

                if (empty($email) || empty($password)) {
                    $_SESSION['reset_alert'] = "All fields are required.";
                    header('Location: index.php?controller=user&action=reset');
                    exit();
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $_SESSION['reset_alert'] = "Invalid email format.";
                    header('Location: index.php?controller=user&action=reset');
                    exit();
                } else {
                    try {
                        // Hash the updated password
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                        // Prepare and execute the SQL statement to update the hashed password
                        $sql = 'UPDATE USER SET PASSWORD = ? WHERE EMAIL = ?';
                        $stmt = $conn->prepare($sql);

                        if (!$stmt) {
                            throw new Exception("Error preparing SQL statement: " . $conn->error);
                        }

                        // Bind parameters
                        $stmt->bind_param('ss', $hashedPassword, $email);

                        // Execute the statement
                        $stmt->execute();

                        // Check the number of affected rows
                        $affectedRows = $stmt->affected_rows;

                        // Close the statement
                        $stmt->close();

                        if ($affectedRows > 0) {
                            // Password reset successful
                            $_SESSION['reset_alert'] = "Reset password success!";
                        } else {
                            // No rows affected, email not found
                            $_SESSION['reset_alert'] = "User not found. Password reset failed.";
                        }
                    } catch (Exception $e) {
                        $_SESSION['reset_alert'] = "An unexpected error occurred: " . $e->getMessage();
                    }
                }

                // Redirect back to the reset page
                header('Location: index.php?controller=user&action=reset');
                exit();
            } else {
                // Handle the case when required keys are not present
                $_SESSION['reset_alert'] = "Invalid request.";
                header('Location: index.php?controller=user&action=reset');
                exit();
            }
        }
    }

   public static function logout()
       //Make sure they cannot 'accidently' log back in after logging out and hitting 'back' on their browser
    {
        // Unset all session variables
        session_unset();

        // Destroy the session
        session_destroy();

        // Empty cache
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Pragma: no-cache");
        header("Expires: 0");

        // Set additional headers to prevent caching
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');

        // Redirect to the home page
        header('Location: index.php?controller=home&action=index');
        exit();
    }


    public static function create()
    {
        global $conn;

        if (isset($_POST['create'])) {
            // Get form data
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $group_id = $_POST['group_id'];

            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare and execute the SQL query
            $sql = 'INSERT INTO USER (FNAME, LNAME, EMAIL, PASSWORD, GROUP_ID) VALUES (?, ?, ?, ?, ?)';
            $stmt = $conn->prepare($sql);

            // Check for errors in preparing the statement
            if (!$stmt) {
                die('Error preparing statement: ' . $conn->error);
            }

            // Bind parameters and execute the statement
            $stmt->bind_param('ssssi', $fname, $lname, $email, $hashed_password, $group_id);
            $stmt->execute();

            // Check for errors in executing the statement
            if ($stmt->error) {
                // Handle the error (e.g., display an error message or redirect to an error page)
                die('Error executing statement: ' . $stmt->error);
            }

            // Get the ID of the inserted user
            $insertedUserId = $stmt->insert_id;

            // Close the statement
            $stmt->close();

            // Redirect
            header("Location: index.php?controller=user&action=list");
            exit();
        }

        // Return false if the 'create' key is not present in the $_POST array
        return false;
    }


    public static function update()
    {
        global $conn;

        // Check if the 'update' key is set in the POST data
        if (isset($_POST['update'])) {
            // Check if 'user_id' and 'group_id' keys are set
            if (isset($_POST['user_id'])) {
                // Get form data
                $user_id = $_POST['user_id'];
                $group_id = $_POST['group_id'];

                // Prepare and execute the SQL update statement
                $sql = 'UPDATE USER SET GROUP_ID = ? WHERE USER_ID = ?';
                $stmt = $conn->prepare($sql);

                // Check if the prepare statement was successful
                if (!$stmt) {
                    // Handle the case when the prepare statement fails
                    return 0;
                }

                $stmt->bind_param('ii', $group_id, $user_id);
                $stmt->execute();

                // Check for errors during the execution of the SQL statement
                if ($stmt->errno) {
                    // Handle the case when an error occurs

                    // Close the statement
                    $stmt->close();

                    return 0;
                }

                // Close the statement
                $stmt->close();

                // Redirect 
                header("Location: index.php?controller=user&action=list");
                exit();
            }
        }
        // Handle the case when 'update' key is not set or required keys are not present
        return 0;
    }


    public static function updateEmail()
    {
        global $conn;



        if (isset($_POST['updateEmail'])) {
            $userId = isset($_SESSION['user']) ? $_SESSION['user']->user_id : null;

            // Check if the user ID is set
            if ($userId === null) {
                return json_encode(array('success' => false, 'message' => 'User ID not set.'));
            }

            // Retrieve updated user information from the POST data
            $email = isset($_POST['email']) ? $_POST['email'] : null;

            // Check if required fields are set
            if ($email === null) {
                return json_encode(array('success' => false, 'message' => 'Email not provided.'));
            }

            // Update user information in the database
            $sql = 'UPDATE `user` SET email = ? WHERE user_id = ?';
            $stmt = $conn->prepare($sql);

            // Check if the prepared statement was successful
            if (!$stmt) {
                return json_encode(array('success' => false, 'message' => 'Failed to prepare statement.'));
            }

            $stmt->bind_param('si', $email, $userId);
            $stmt->execute();

            if ($stmt->errno) {
                $stmt->close();
                return json_encode(array('success' => false, 'message' => 'Error updating email.'));
            }

            $stmt->close();

            // Return a success response
            return json_encode(array('success' => true, 'message' => 'Email updated successfully.'));
        }

        return json_encode(array('success' => false, 'message' => 'Invalid request.'));
    }

    /*public static function updatePassword()
    {
        global $conn;

        if (isset($_POST['updatePassword'])) {
            $userId = isset($_SESSION['user']) ? $_SESSION['user']->user_id : null;

            // Check if the user ID is set
            if ($userId === null) {
                return json_encode(array('success' => false, 'message' => 'User ID not set.'));
            }

            // Retrieve updated user information from the POST data
            $newPassword = isset($_POST['passwordInput']) ? $_POST['passwordInput'] : null;

            // Check if required fields are set
            if ($newPassword === null) {
                return json_encode(array('success' => false, 'message' => 'Password not provided.'));
            }

            // Hash the new password before updating in the database
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update user information in the database
            $sql = 'UPDATE `user` SET password = ? WHERE user_id = ?';
            $stmt = $conn->prepare($sql);

            // Check if the prepared statement was successful
            if (!$stmt) {
                return json_encode(array('success' => false, 'message' => 'Failed to prepare statement.'));
            }

            $stmt->bind_param('si', $hashedPassword, $userId);
            $stmt->execute();

            if ($stmt->errno) {
                $stmt->close();
                return json_encode(array('success' => false, 'message' => 'Error updating password.'));
            }

            $stmt->close();

            // Return a success response
            return json_encode(array('success' => true, 'message' => 'Password updated successfully.'));
        }

        return json_encode(array('success' => false, 'message' => 'Invalid request.'));
    }
    */
    public static function delete()
    {
        global $conn;

        // Check if the 'delete' key is present in the $_POST array
        if (isset($_POST['delete']) && isset($_POST['user_id'])) {

            // Get form data
            $user_id = $_POST['user_id'];
            $group_id = $_POST['group_id'];

            // Validate $user_id (ensure it's a positive integer, for example)

            if ($group_id == 3) {
                // Check if there is only one admin left
                $checksql = 'SELECT COUNT(*) as count FROM USER WHERE GROUP_ID = 3';
                $checkResult = $conn->query($checksql);
                $count = $checkResult->fetch_assoc()['count'];

                if ($count <= 1) {
                    // Do not delete the last admin
                    echo "Cannot delete the last admin. Assign a new admin before deleting.";
                    return;
                }

                // Delete the admin
                $deletesql = 'DELETE FROM USER WHERE USER_ID = ? AND GROUP_ID = 3';
            } else {
                // Delete a regular user
                $deletesql = 'DELETE FROM USER WHERE USER_ID = ?';
            }

            // Prepare and execute the SQL query
            $stmt = $conn->prepare($deletesql);
            $stmt->bind_param('i', $user_id);
            $stmt->execute();

            // Check for errors in executing the statement
            if ($stmt->error) {
                // Handle the error (e.g., display an error message or redirect to an error page)
                die('Error executing statement: ' . $stmt->error);
            }

            // Close the statement
            $stmt->close();

            // Redirect
            header("Location: index.php?controller=user&action=list");
            exit();
        }

        // Return false if the 'delete' key is not present in the $_POST array or 'user_id' is not set
        return 0;
    }


    public static function deleteAccount()
    {
        global $conn;

        // Check if the 'deleteAccount' key is present in the $_POST array
        if (isset($_POST['deleteAccount'])) {

            // Check if user ID is present in the session
            $userId = isset($_SESSION['user']) ? $_SESSION['user']->user_id : null;

            // Validate user ID
            if (!$userId) {
                die('Error: User ID not available. Please log in.');
            }

            // Check if group ID is present in the session
            $groupId = isset($_SESSION['user']) ? $_SESSION['user']->group_id : null;

            if ($groupId == 3) {
                // Check if there is only one admin left
                $checksql = 'SELECT COUNT(*) as count FROM USER WHERE GROUP_ID = 3';
                $checkResult = $conn->query($checksql);
                $count = $checkResult->fetch_assoc()['count'];

                if ($count <= 1) {
                    // Do not delete the last admin
                    echo "Cannot delete the last admin. Assign a new admin before deleting.";
                    return;
                }

                // Delete the admin
                $deletesql = 'DELETE FROM USER WHERE USER_ID = ? AND GROUP_ID = 3';
            } else {
                // Delete a regular user
                $deletesql = 'DELETE FROM USER WHERE USER_ID = ?';
            }

            // Prepare and execute the SQL query
            $stmt = $conn->prepare($deletesql);
            $stmt->bind_param('i', $userId);
            $stmt->execute();

            // Check for errors in executing the statement
            if ($stmt->error) {
                // Handle the error (e.g., display an error message or redirect to an error page)
                die('Error executing statement: ' . $stmt->error);
            }

            // Close the statement
            $stmt->close();

            // Unset all session variables
            session_unset();

            // Destroy the session
            session_destroy();

            // Empty cache
            header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Pragma: no-cache");
            header("Expires: 0");

            // Redirect to the home page after successful account deletion
            header('Location: index.php?controller=home&action=index');
            exit();
        }

        // Return false if the 'deleteAccount' key is not present in the $_POST array
        return false;
    }




    // for passing the cart items corresponding to a user to the cart page
    public static function cart()
    {
        global $conn;
        $user = isset($_SESSION['user']) ? $_SESSION['user']->user_id : -1;

        $sql = "SELECT PRODUCT.*, USER_PRODUCT.QTY
        FROM PRODUCT
        JOIN USER_PRODUCT ON PRODUCT.PRODUCT_ID = USER_PRODUCT.PRODUCT_ID
        WHERE USER_PRODUCT.USER_ID = ?;";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $user);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows > 0) {
            $rows = array();
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            return $rows;
        }
        return null;
    }

    // add an item to the cart
    public static function bag()
    {
        global $conn;
        $user = isset($_SESSION['user']) ? $_SESSION['user']->user_id : null;
        $product = isset($_GET['id']) ? $_GET['id'] : null;

        var_dump($user);
        if ($user == null || $product == null) {
            header("Location: 404.php");
            return;
        }

        if (isset($_POST['addToCartBtn'])) {

            // this section is to see if the product is already in the user's cart.
            // if the product is already in the cart, it wont insert (PK violation)
            // instead, it will update the quantity to be the sum of the old quantity
            // and the new quantity.
            $sql = "SELECT QTY FROM USER_PRODUCT WHERE USER_ID = ? AND PRODUCT_ID = ?;";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ii', $user, $product);
            $stmt->execute();
            $cartQty = $stmt->get_result(); // the quantity already in cart
            $stmt->close();

            if ($cartQty->num_rows > 0) {
                $rows = array();
                while ($row = $cartQty->fetch_assoc()) {
                    $rows[] = $row;
                }

                // to ensure the added quantity is not bigger than 10
                $qty = ($_POST['quantity'] + intval($rows[0]['QTY']) > 10)
                    ? 10
                    : $_POST['quantity'] + intval($rows[0]['QTY']);

                $sql = "UPDATE USER_PRODUCT SET QTY = ? WHERE USER_ID = ? AND PRODUCT_ID = ?;";
                $stmt = $conn->prepare($sql);

                // Check if the prepare statement was successful
                if (!$stmt) {
                    // Handle the case when the prepare statement fails
                    return 0;
                }

                $stmt->bind_param('iii', $qty, $user, $product);
                $stmt->execute();

                // Check for errors during the execution of the SQL statement
                if ($stmt->errno) {
                    // Handle the case when an error occurs

                    // Close the statement
                    $stmt->close();

                    return 0;
                }

                // Close the statement
                $stmt->close();
            } else {
                $qty = $_POST['quantity'];
                $sql = "INSERT INTO USER_PRODUCT (USER_ID, PRODUCT_ID, QTY) VALUES (?, ?, ?)";

                $stmt = $conn->prepare($sql);

                // Check for errors in preparing the statement
                if (!$stmt) {
                    die('Error preparing statement: ' . $conn->error);
                }

                // Bind parameters and execute the statement
                $stmt->bind_param('iii', $user, $product, $qty);
                $stmt->execute();

                // Check for errors in executing the statement
                if ($stmt->error) {
                    // Handle the error (e.g., display an error message or redirect to an error page)
                    die('Error executing statement: ' . $stmt->error);
                }

                // Close the statement
                $stmt->close();
            }

            // Redirect to a success page or do other post-creation actions
            header("Location: index.php?controller=user&action=cart");
            exit();
        }
    }

    // to remove an item from a users cart
    public static function unbag()
    {
        global $conn;
        $user_id = isset($_SESSION['user']) ? $_SESSION['user']->user_id : '';
        $product_id = isset($_GET['product_id']) ? $_GET['product_id'] : '';

        if (!empty($user_id) && !empty($product_id)) {
            $sql = "DELETE FROM USER_PRODUCT WHERE USER_ID = ? AND PRODUCT_ID = ?;";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ii', $user_id, $product_id);
            $stmt->execute();

            // Check for errors in executing the statement
            if ($stmt->error) {
                // Handle the error (e.g., display an error message or redirect to an error page)
                die('Error executing statement: ' . $stmt->error);
            }

            // Close the statement
            $stmt->close();
        }

        return 0;
    }
    private static function redirectToCart()
    {
        header("Location: index.php?controller=user&action=cart");
        exit();
    }
    public static function clear()
    {
        //header("Location: index.php?controller=home&action=index");
        global $conn;
        $user_id = isset($_SESSION['user']) ? $_SESSION['user']->user_id : '';

        if (!empty($user_id) && isset($_POST['clear'])) {
            $sql = "DELETE FROM USER_PRODUCT WHERE USER_ID = ?;";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $user_id);
            $stmt->execute();

            // Check for errors in executing the statement
            if ($stmt->error) {
                // Handle the error (e.g., display an error message or redirect to an error page)
                die('Error executing statement: ' . $stmt->error);
            }

            // Close the statement
            $stmt->close();
        }
        self::redirectToCart();
        return 0;
    }

    // this is to update the quantity of a specific product dynamically using ajax + mysql
    public static function updateQty()
    {
        global $conn;
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        ob_start();

        $user_id = isset($_SESSION['user']) ? $_SESSION['user']->user_id : 0;
        $product_id = isset($_GET['id']) ? $_GET['id'] : 0;
        $qty = isset($_POST['quantity' . $product_id]) ? $_POST['quantity' . $product_id] : 0;

        if (
            ($user_id != 0 && $product_id != 0 && $qty != 0) &&
            (isset($_POST['btnUp' . $product_id]) || isset($_POST['btnDown' . $product_id]))
        ) {
            $sql = "UPDATE USER_PRODUCT SET QTY = ? WHERE USER_ID = ? AND PRODUCT_ID = ?;";

            $stmt = $conn->prepare($sql);

            // Check if the prepare statement was successful
            if (!$stmt) {
                // Handle the case when the prepare statement fails
                self::redirectToCart();
            }

            $stmt->bind_param('iii', $qty, $user_id, $product_id);
            $stmt->execute();

            // Check for errors during the execution of the SQL statement
            if ($stmt->errno) {
                // Handle the case when an error occurs
                $stmt->close();
                self::redirectToCart();
            }

            $stmt->close();
            self::redirectToCart();
        } else {
            self::redirectToCart();
        }
        ob_end_flush();
    }
}

?>