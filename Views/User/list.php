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
        <h1 class="py-4">MANAGE USERS AND PERMISSIONS</h1>
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
                // Check if $data is defined and not empty
                if (isset($data) && is_array($data) && !empty($data)) {
                    foreach ($data as $user) {
                        echo '<tr>
                            <td>' . $user['USER_ID'] . '</th>
                            <td>' . $user['GROUP_ID'] . '</td>
                            <td>' . $user['GROUP_NAME'] . '</td> 
                            <td>' . $user['FNAME'] . '</td>
                            <td>' . $user['LNAME'] . '</td>
                            <td>' . $user['EMAIL'] . '</td>

                        <td>
                        <form method="post" action="index.php?controller=user&action=edit&id=' . $user['USER_ID'] . '">
                            <input type="hidden" name="user_id" value="' . $user['USER_ID'] . '">
                            <button type="submit" class="btn btn-primary" name="edit">Edit</button>
                        </form>
                        </td>

                        <td>
                        <form method="post" action="index.php?controller=user&action=delete">
                            <input type="hidden" name="user_id" value="' . $user['USER_ID'] . '">
                            <input type="hidden" name="group_id" value="' . $user['GROUP_ID'] . '">
                            <button type="submit" class="btn btn-danger" name="delete">Remove</button>
                        </form>
                        </td>
                    </tr>';
                    }
                } else {
                    echo '<tr><td colspan="8">No data available</td></tr>';
                }
                ?>
            </tbody>
        </table>

        <form method="post" action="index.php?controller=user&action=add">
            <button type="submit" class="btn btn-primary" name="add">CREATE NEW USER ACCOUNT</button>
        </form>
    </div>

    <!-- Bootstrap JS (optional, for Bootstrap components) -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>

<footer>
    <?php include_once("../../footer.html"); ?>
</footer>

</html>