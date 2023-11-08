<?php
session_start();
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT USER_ID, FNAME, LNAME, GROUP_ID, PASSWORD FROM USER WHERE EMAIL = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $fname, $lname, $group_id, $storedPassword);
        $stmt->fetch();

        if (password_verify($password, $storedPassword)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['fname'] = $fname;
            $_SESSION['lname'] = $lname;
            $_SESSION['group_id'] = $group_id;

            $stmt->close();
            header('Location: ' . getRedirectPage($group_id));
        } else {
            $stmt->close();
            $_SESSION['login_error'] = "Invalid username or password";
            header('Location: login.php');
        }
    } else {
        $stmt->close();
        $_SESSION['login_error'] = "Invalid username or password";
        header('Location: login.php');
    }
}

function getRedirectPage($group_id) {
    if ($group_id === 1) {
        return '../client/index.php';
    } elseif ($group_id === 2) {
        return '../moderator/index.php';
    } elseif ($group_id === 3) {
        return '../admin/index.php';
    } else {
        return 'login.php';
    }
}
?>
