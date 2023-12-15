<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php include_once __DIR__ . "/../../navbar.php"; ?>
    <div class="container my-5">
        <h1 class="py-2">MANAGE USERS AND PERMISSIONS</h1>

        </br>
        <form method="post" action="?controller=user&action=add">
            <button type="submit" class="btn btn-primary" name="add">CREATE NEW USER ACCOUNT</button>
        </form>
        </br>

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
                        <form method="post" action="?controller=user&action=edit&id=' . $user['USER_ID'] . '">
                            <input type="hidden" name="user_id" value="' . $user['USER_ID'] . '">
                            <button type="submit" class="btn btn-primary" name="edit">Edit</button>
                        </form>
                        </td>

                        <td>
                        <form method="post" action="?controller=user&action=delete">
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
    </div>
    <footer>
        <?php include_once __DIR__ . "/../../footer.html"; ?>
    </footer>
</body>
</html>
