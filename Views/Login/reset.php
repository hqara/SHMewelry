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
        <h2 class="center">Reset My Password</h2>
        <form method="post" action="index.php?controller=user&action=reset">
        <!---<input type="hidden" name="username" value="<?php //echo $user->email; ?>"> -->
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
                        <label for="password">New Password:</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="password" id="password" name="password" required>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="update" value="Update">
                    </td>
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
