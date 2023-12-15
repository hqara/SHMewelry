<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    
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
  
    <?php include_once dirname(__FILE__) .  "/../../navbar.php"; ?>
    <div class="login-box">
        <?php
            if (isset($_SESSION['login_alert'])) {
                echo "<p class='error'>" . $_SESSION['login_alert'] . "</p>";
                unset($_SESSION['login_alert']);
            }
        ?>
        <h2 class="center">Login</h2>
   
        <form method="post" action="?controller=user&action=login">
            <table class="center">
                <tr>
                    <td>
                        <label for="username">Username:</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" id="email" name="email" required>
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
                        <input type="submit" name="login" value="Sign In">
                    </td>
                </tr>
                <tr>
                    <td><a style="text-decoration:underline" href="?controller=user&action=reset"> Forgot Password?</a></td>
                </tr>
                <tr>
                    <td>Don't have an Account? <a style="text-decoration:underline" href="?controller=user&action=register">Register</a></td>
                </tr>
            </table>
        </form>
    </div>

    <?php include_once dirname(__FILE__) .  "/../../footer.html"; ?>

</body>
</html>
