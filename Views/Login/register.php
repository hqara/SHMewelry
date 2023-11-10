<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        session_start();
        include('../../navbar.php');
    ?>
    <title>SHMEWELRY Registration</title>
    <style>
        .center {
            text-align: center;
        }

        .registration-box {
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
    <div class="registration-box">
        <h2 class="center">SHMEWELRY Registration</h2>
        <form method="post" action="register_process.php">
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
                        <select id="group" name="group" required>
                            <!-- <option value="1">Client</option> -->
                            <option value="2">Moderator</option>
                            <option value="3">Admin</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" value="Register">
                    </td>
                </tr>
                <tr>
                    <td>Already have an Account? <a href="login.php">Login</a></td>
                </tr>
            </table>
        </form>
    </div>
</body>
<footer>
    <?php
        include_once("../../footer.html");
    ?>
</footer>
</html>
