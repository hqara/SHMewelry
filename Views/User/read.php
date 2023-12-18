<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="justify-content-start">

    <?php include_once __DIR__ . "/../../navbar.php"; ?>

    <div class="container my-5">
        <?php
        // Check if $data is defined and not empty
        if (isset($data) && is_array($data) && !empty($data)) {
            echo '<h1 class="text-center mx-auto">Hi, ' . $_SESSION['user']->fname . '!</h1>';
            echo '<h2 class="py-2 text-left mx-auto">CHANGE PASSWORD</h2>';
            echo '<form method="post" action="?controller=user&action=updatePassword">';
            echo '<table class="table">';
            echo '<tr>
                    <td>
                        <h3 class="py-2 text-left mx-auto">Email</h3>
                        <p name="emailP" class="py-2 text-left mx-auto">' . $_SESSION['user']->email . '</p>
                        <input type="hidden" name="email" value="' . $_SESSION['user']->email . '">
                    </td>
                </tr>';
            echo '<tr>
                    <td>
                        <h3 class="py-2 text-left mx-auto">New Password</h3>
                        <input type="password" class="form-control" name="passwordInput" autocomplete="off" placeholder="Enter New Password">
                    </td>
                </tr>';
            echo '<tr>
                    <td>
                        <button type="submit" class="btn btn-primary" style="margin-top: 20px;">CHANGE PASSWORD</button>
                    </td>
                </tr>';
            echo '</table>';
            echo '</form>';

            echo '<form method="post" action="index.php?controller=user&action=deleteAccount">';
            echo '<table class="table">';
            echo '<tr>
                    <td>
                        <h3 class="py-2 text-left mx-auto">Delete My Account</h3>
                        <p class="py-2 text-left mx-auto">NOTE: Account will NOT BE RECOVERABLE once deleted.</p>
                    </td>
                    <td>
                        <input type="hidden" name="user_id" value="' . $_SESSION['user']->user_id . '">
                        <button type="submit" class="btn btn-danger" style="margin-top: 20px;" name="deleteAccount">DELETE</button>
                    </td>
                </tr>';
            echo '</table>';
            echo '</form>';
        } else {
            echo '<p>No data available.</p>';
        }
        ?>
    </div>

    <?php include_once __DIR__ . "/../../footer.html"; ?>

</body>

</html>
