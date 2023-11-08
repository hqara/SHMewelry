<!DOCTYPE html>
<html>
<head>
    <title>SHMEWELRY Registration</title>
</head>
<body>
    <h2>SHMEWELRY Registration</h2>
    <?php
    session_start();
    ?>
    <form method="post" action="register_process.php">
        <label for="fname">First Name:</label>
        <input type="text" id="fname" name="fname" required><br><br>

        <label for="lname">Last Name:</label>
        <input type="text" id="lname" name="lname" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="group">User Group:</label>
        <select id="group" name="group" required>
            <!-- <option value="1">Client</option> -->
            <option value="2">Moderator</option>
            <option value="3">Admin</option>
        </select><br><br>

        <input type="submit" value="Register">
    </form>
</body>
</html>
