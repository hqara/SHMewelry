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

        .registration-box {
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

    <?php include dirname(__FILE__) . '/../../navbar.php'; ?>

    <div class="registration-box">
        <?php
            if (isset($_SESSION['register_alert'])) {
                echo "<p class='error'>" . $_SESSION['register_alert'] . "</p>";
                unset($_SESSION['register_alert']);
            }
        ?>
        <h2 class="center">SHMEWELRY Registration</h2>
       
        <form method="post" action="?controller=user&action=register">
            <table class="center">
                <tr>
                    <td>
                        <label for="fname">First Name:</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" id="fname" name="fname" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="lname">Last Name:</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" id="lname" name="lname" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="email">Email:</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="email" id="email" name="email" required>
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
                    <td>
                        <label for="group">User Group:</label>
                    </td>
                </tr>
                <tr>
                    <td>
                    <select id="group" name="group_id" required>
                        <option value="1">Client</option>
                        <option value="2">Moderator</option>
                        <option value="3">Admin</option>
                    </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="create" value="Register">
                    </td>
                </tr>
                <tr>
                    <td>Already have an Account? <a style="text-decoration:underline" href="?controller=user&action=login">Login</a></td>
                </tr>
            </table>
        </form>
    </div>

    <?php include_once dirname(__FILE__) . "/../../footer.html"; ?>
</body>
</html>
