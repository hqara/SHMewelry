<?php

include '../../Models/User.php';

$adminModel = new User();

if (isset($_GET['editid'])) {
    $user_id = $_GET['editid'];

    $user = $adminModel->getById($user_id);

    if (!$user) {
        die("User not found.");
    }
} else {
    die("User ID not provided.");
}

if (isset($_POST['update'])) {
    // Get form data
    $group_id = $_POST['group_id'];
    $adminModel->update($group_id, $user_id);
    header('location: display.php');
    exit();
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
        <h1>Edit User ID=<?php echo $user_id; ?> Permissions</h1>
        <form method="post">
            <div class="form-group">
                <label>Group ID</label>
                <input type="text" class="form-control" id="group_id" name="group_id" autocomplete="off"
                    value="<?php echo $user['GROUP_ID']; ?>" required>
            </div>

            <button type="submit" class="btn btn-primary" name="update">UPDATE</button>
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
