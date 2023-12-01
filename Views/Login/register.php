<!DOCTYPE html>
<html lang="en">
<head>
    <title>SHMEWELRY Registration</title>
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
    <header>
        <?php
            include dirname(__FILE__) . '/../../navbar.php';
        ?>
    </header>
    <div class="registration-box">
        <?php
            if (isset($_SESSION['registration_error'])) {
                echo "<p class='error'>" . $_SESSION['registration_error'] . "</p>";
                unset($_SESSION['registration_error']);
            }
        ?>
        <h2 class="center">SHMEWELRY Registration</h2>
       
        <form method="post" action="Controllers/RegisterController.php">
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
                    <td>Already have an Account? <a style="text-decoration:underline" href="index.php?controller=login&action=login">Login</a></td>
                </tr>
            </table>
        </form>
    </div>
    <footer>
    <?php
        include_once dirname(__FILE__) . "/../../footer.html";
    ?>
</footer>
</body>
</html>
