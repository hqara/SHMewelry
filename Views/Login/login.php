<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        include('../../navbar.php');
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHMewelry</title>
    <style>
        .center {
            text-align: center;
        }

        .login-box {
            background-color: #e6f3f8;
            width: 700px; /* Set the background color of the gray box */
            margin: auto; /* Center the box horizontally */
            padding: 20px; /* Add some padding for better aesthetics */
            border-radius: 8px; /* Add rounded corners to the box */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add a subtle box shadow for depth */
            margin-bottom: 20px;
        }
        
    </style>
</head>
<body>
    <div class="login-box">
        <h2 class="center">Login</h2>
        <?php
            if (isset($_SESSION['login_error'])) {
                echo "<p class='error'>" . $_SESSION['login_error'] . "</p>";
                unset($_SESSION['login_error']);
            }
        ?>
        <form method="post" action="login_process.php">
            <table class="center">
                <tr>
                    <td>
                        <label for="username">Username:</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" id="username" name="username" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="password">Password:</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="password" id="password" name="password" required>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" value="Sign In">
                    </td>
                </tr>
                <tr>
                    <td><a href="#"> Forgot Password?</a></td>
                </tr>
                <tr>
                    <td>Don't have an Account? <a href="register.php">Register</a></td>
                </tr>
            </table>
        </form>
    </div>
    <section></section>
</body>
    <section></section>

<footer>
    <?php
        include_once("../../footer.html");
    ?>
</footer>
</html>
