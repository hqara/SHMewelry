<!DOCTYPE html>
<html>
<head>
    <title>Client Registration</title>
</head>
<body>
    <h2>Client Registration</h2>
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

        
        <input type="hidden" name="group" value="1">

        <br><br>
       
        <input type="submit" value="Register">
    </form>
</body>
</html>
