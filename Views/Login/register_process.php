<?php
session_start();
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $group = $_POST['group'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    if ($hashedPassword === false) {
        // Password hashing failed
        $_SESSION['registration_error'] = "Password hashing failed";
        header('Location: register.php');
        exit;
    }

    $query = "INSERT INTO USER (FNAME, LNAME, EMAIL, PASSWORD, GROUP_ID) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $fname, $lname, $email, $hashedPassword, $group);

    if ($stmt->execute()) {
        $_SESSION['registration_success'] = "Registration successful!";
        header('Location: login.php');
    } else {
        $_SESSION['registration_error'] = "Error: " . $stmt->error;
        header('Location: register.php');
    }

    $stmt->close();
} else {
    header('Location: register.php');
}
?>
