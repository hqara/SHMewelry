<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud operations</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <header>
    <?php include('../../navbar.php'); ?>
    </header>
</head>
<body>
    <div class="container my-5">
        <h1>MANAGE USERS AND PERMISSIONS</h1>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">User ID</th>
                    <th scope="col">Group ID</th>
                    <th scope="col">Role</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                include '../../Models/User.php';
                $adminModel = new User();
                $users = $adminModel->getAllUsersInfo();

                foreach ($users as $user) {
                    echo '<tr>
                        <td>' . $user['USER_ID'] . '</th>
                        <td>' . $user['GROUP_ID'] . '</td>
                        <td>' . $user['GROUP_NAME'] . '</td> 
                        <td>' . $user['FNAME'] . '</td>
                        <td>' . $user['LNAME'] . '</td>
                        <td>' . $user['EMAIL'] . '</td>
                        <td><button class="btn btn-primary"><a href="edit.php?editid=' . $user['USER_ID'] . '" class="text-light">Edit</a></button></td>
                        <td><button class="btn btn-danger"><a href="remove.php?removeid=' . $user['USER_ID'] . '" class="text-light">Remove</a></button></td>
                    </tr>';
                }
                ?>
            </tbody>
        </table>
        <button class="btn btn-primary my-5"><a href="add.php" class="text-light">CREATE NEW USER ACCOUNT</a></button>
    </div>

    <!-- Bootstrap JS (optional, for Bootstrap components) -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
<footer>
    <?php
        include_once("../../footer.html");
    ?>
</footer>
</html>
