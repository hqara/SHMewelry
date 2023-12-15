<?php
// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user']) && !empty($_SESSION['user']);

// Debugging: Dump the entire user object
if ($isLoggedIn) {
    // Retrieve the group_id from the user object in the session
    $groupId = isset($_SESSION['user']->group_id) ? $_SESSION['user']->group_id : null;
    $userId = isset($_SESSION['user']->user_id) ? $_SESSION['user']->user_id : null;

    // Now, $groupId contains the value of group_id for the logged-in user
    echo "Group ID: " . $groupId;
} else {
    // User is not logged in
    echo "User is not logged in.";
    // You might want to redirect the user to the login page or handle this case appropriately
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <?php
    // Encode the user's password for JavaScript
    $encodedPassword = htmlspecialchars(json_encode($_SESSION['user']->password), ENT_QUOTES, 'UTF-8');
    echo '<script>var userPassword = ' . $encodedPassword . ';</script>';
    ?>
    <script>
        $(document).ready(function () {
            // Change Email button click handling
            $('[name="changeEmail"]').on('click', function () {
                var emailInput = $('[name="emailInput"]');
                var emailP = $('[name="emailP"]');
                var changeEmailButton = $('[name="changeEmail"]');

                emailInput.toggle();
                emailP.toggle();

                // Change button text and functionality
                if (emailInput.is(':visible')) {
                    changeEmailButton.text('SAVE');
                    changeEmailButton.attr('name', 'update');
                } else {
                    changeEmailButton.text('CHANGE');
                    changeEmailButton.attr('name', 'changeEmail');
                }
            });

            // Save (Update) Email button click handling
            $('[name="update"]').on('click', function () {
                var newEmail = $('[name="emailInput"]').val();

                // Make an AJAX request to update the email
                $.ajax({
                    type: 'POST',
                    url: '?controller=user&action=updateEmail',
                    data: { updateEmail: true, user_id: <?php echo $_SESSION['user_id']; ?>, emailInput: newEmail },
                    success: function (response) {
                        // Handle the response if needed
                        console.log(response);

                        // Update the content of the paragraph with the new email
                        $('[name="emailP"]').text(newEmail);

                        // Toggle visibility of input and paragraph elements
                        $('[name="emailInput"]').toggle();
                        $('[name="emailP"]').toggle();
                    },
                    error: function (error) {
                        // Handle the error if needed
                        console.error(error);
                    }
                });
            });

            // Change Password button click handling
            $('[name="changePassword"]').on('click', function () {
                var passwordInput = $('[name="passwordInput"]');
                var passwordP = $('[name="passwordP"]');
                var changePasswordButton = $('[name="changePassword"]');

                // Toggle input type between text and password
                passwordInput.attr('type', passwordInput.attr('type') === 'password' ? 'text' : 'password');
                passwordInput.toggle(); // Toggle the visibility of the password input
                passwordP.toggle(); // Toggle the visibility of the paragraph element

                // Change button text and functionality
                if (passwordInput.attr('type') === 'text') {
                    changePasswordButton.text('SAVE');
                    changePasswordButton.attr('name', 'updatePassword');
                } else {
                    changePasswordButton.text('CHANGE');
                    changePasswordButton.attr('name', 'changePassword');
                }

                // Set the content of the paragraph based on the user's password
                passwordP.text(passwordInput.attr('type') === 'text' ? userPassword : strRepeat('*', userPassword.length));

                // Set the value of the input field to the actual password when in text mode
                if (passwordInput.attr('type') === 'text') {
                    passwordInput.val(userPassword);
                } else {
                    passwordInput.val(''); // Clear the value when in password mode
                }
            });

            // Save (Update) Password button click handling
            $('[name="updatePassword"]').on('click', function () {
                var newPassword = $('[name="passwordInput"]').val();

                // Make an AJAX request to update the password
                $.ajax({
                    type: 'POST',
                    url: '?controller=user&action=updatePassword',
                    data: { updatePassword: true, user_id: <?php echo $_SESSION['user_id']; ?>, passwordInput: newPassword },
                    success: function (response) {
                        // Handle the response if needed
                        console.log(response);

                        // Update the content of the paragraph with asterisks (*) for password
                        var maskedPassword = strRepeat('*', newPassword.length);
                        $('[name="passwordP"]').text(maskedPassword);

                        // Toggle visibility of input and paragraph elements
                        $('[name="passwordInput"]').toggle();
                        $('[name="passwordP"]').toggle();
                    },
                    error: function (error) {
                        // Handle the error if needed
                        console.error(error);
                    }
                });
            });

            // Custom function to repeat a character
            function strRepeat(char, length) {
                return Array(length + 1).join(char);
            }
        });
    </script>
</head>

<body class="justify-content-start">

    <?php include_once __DIR__ . "/../../navbar.php"; ?>

    <div class="container my-5">
        <?php
        // Check if $data is defined and not empty
        if (isset($data) && is_array($data) && !empty($data)) {
            echo '<h1 class="text-center mx-auto">Hi, ' . $_SESSION['user']->fname . '!</h1>';
            echo '<h2 class="py-2 text-left mx-auto">MANAGE MY ACCOUNT</h2>';
            echo '<table class="table">';
            echo '<tr>
                    <td>
                        <h3 class="py-2 text-left mx-auto">Email</h3>
                        <p name="emailP" class="py-2 text-left mx-auto">' . $_SESSION['user']->email . '</p>
                        <input type="text" class="form-control" name="emailInput" autocomplete="off" value="' . $_SESSION['user']->email . '" style="display: none;">
                    </td>
                    <td><button type="button" class="btn btn-primary" style="margin-top: 20px;" name="changeEmail">CHANGE</button></td>
                </tr>';
            echo '<tr>
                    <td>
                        <h3 class="py-2 text-left mx-auto">Password</h3>
                        <p name="passwordP" class="py-2 text-left mx-auto">' . str_repeat('*', strlen($_SESSION['user']->password)) . '</p>
                        <input type="password" class="form-control" name="passwordInput" autocomplete="off" style="display: none;" placeholder="Enter New Password">
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary" style="margin-top: 20px;" name="changePassword">CHANGE</button>
                    </td>
                </tr>';
            echo '<tr>
                    <td>
                        <h3 class="py-2 text-left mx-auto">Delete My Account</h3>
                        <p class="py-2 text-left mx-auto">NOTE: Account will NOT BE RECOVERABLE once deleted.</p>
                    </td>
                    <td>
                        <form method="post" action="?controller=user&action=delete">
                            <input type="hidden" name="user_id" value="' . $_SESSION['user']->user_id . '">
                            <input type="hidden" name="group_id" value="' . $_SESSION['user']->group_id . '">
                            <button type="button" class="btn btn-danger" style="margin-top: 20px;" name="delete">DELETE</button>
                        </form>
                    </td>
                </tr>';
            echo '</table>';
        } else {
            echo '<p>No data available.</p>';
        }
        ?>
    </div>

    <?php include_once __DIR__ . "/../../footer.html"; ?>

</body>

</html>
