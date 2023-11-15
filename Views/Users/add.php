<?php

include '../../Models/User.php';
$adminModel = new User();

if (isset($_POST['create'])) {
    // Get form data
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $group_id = $_POST['group_id'];

    // Call the create method to insert a new user
    $insertedUserId = $adminModel->create($fname, $lname, $email, $password, $group_id);

    if ($insertedUserId) {
        // Redirect to the display page after successful user creation
        header('location: display.php');
        exit();
    } else {
        // Handle the error, e.g., display an error message
        echo "Error creating user.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <header>
        <?php include('../../navbar.php'); ?>
    </header>
</head>

<body>
    <div class="container my-5">
        <h1>Create New User</h1>
        <form method="post">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" class="form-control" id="fname" name="fname" autocomplete="off" required>
            </div>

            <div class="form-group">
                <label>Last Name</label>
                <input type="text" class="form-control" id="lname" name="lname" autocomplete="off" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" id="email" name="email" autocomplete="off" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" autocomplete="off" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <input type="checkbox" id="showPassword"> Show
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Group ID</label>
                <input type="text" class="form-control" id="group_id" name="group_id" autocomplete="off" required>
            </div>

            <button type="submit" class="btn btn-primary" name="create">CREATE</button>
            <button type="button" class="btn btn-primary" name="back" onclick="window.history.back();">GO BACK</button>
        </form>
    </div>
     <!-- JavaScript to toggle password visibility -->
     <script>
        document.getElementById('showPassword').addEventListener('change', function () {
            var passwordInput = document.getElementById('password');
            passwordInput.type = this.checked ? 'text' : 'password';
        });
    </script>

</body>


<footer>
    <?php
    include_once("../../footer.html");
    ?>
</footer>

</html>
