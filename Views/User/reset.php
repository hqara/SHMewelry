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

        .reset-box {
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
    <?php  include_once dirname(__FILE__) .  "/../../navbar.php"; ?>

    <div class="reset-box">
        <?php
            if (isset($_SESSION['reset_alert'])) {
                echo "<p class='error'>" . $_SESSION['reset_alert'] . "</p>";
                unset($_SESSION['reset_alert']);
            }
        ?>

        <h2 class="center">Reset My Password</h2>
        <form method="post" action="index.php?controller=user&action=reset">
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
                        <input type="submit" name="reset" value="Update">
                    </td>
                </tr>
            </table>
        </form>
    </div>
  
    <?php include_once dirname(__FILE__) .  "/../../footer.html"; ?>

</body>
</html>
