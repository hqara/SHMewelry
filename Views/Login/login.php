<!DOCTYPE html>
<html>
<head>
    <title>SHMEWELRY Login</title>
</head>
<body>
    <h2>SHMEWELRY Login</h2>
    <?php
    session_start();

    if (isset($_SESSION['login_error'])) {
        echo "<p class='error'>" . $_SESSION['login_error'] . "</p>";
        unset($_SESSION['login_error']);
    }
    ?>

    <form method="post" action="login_process.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>
