<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHMewelry</title>
    <style>
        .center {
            text-align: center;
        }

        .login-box {
            background-color: #e6f3f8;
            width: 700px; 
            margin: auto; 
            padding: 20px; 
            border-radius: 8px; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        
    </style>
</head>
<body>
    <header>
    <?php
        include_once dirname(__FILE__) .  "/../../navbar.php";
    ?>
    </header>
    <div class="login-box">
        <?php
            if (isset($_SESSION['login_error'])) {
                echo "<p class='error'>" . $_SESSION['login_error'] . "</p>";
                unset($_SESSION['login_error']);
            }
        ?>
        <h2 class="center">Login</h2>
   
        <form method="post" action="index.php?controller=login&action=login">
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
                    <td><a style="text-decoration:underline" href="index.php?controller=login&action=reset"> Forgot Password?</a></td>
                </tr>
                <tr>
                    <td>Don't have an Account? <a style="text-decoration:underline" href="index.php?controller=login&action=register">Register</a></td>
                </tr>
            </table>
        </form>
    </div>
    <section></section>
    <section></section>
    <footer>
    <?php
        include_once dirname(__FILE__) .  "/../../footer.html";
    ?>
</footer>
</body>
</html>
