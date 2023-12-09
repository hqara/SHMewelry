<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>

<body>
    <header>
        <?php include_once __DIR__ . "/../../navbar.php"; ?>
    </header>

    <div class="container my-5 text-center">
        <div class="alert alert-info text-center" style="background-color: #E6F3F8; border-color: #6AC5FE;">
            <strong>User Role and Rights Information</strong><br/>
            <p><strong>Recall:</strong></p>
            <p>
                Group ID 3 is associated with the <strong>Admin</strong> role, granting Admin rights and permissions.
            </p>
            <p>
                Group ID 2 is associated with the <strong>Moderator</strong> role, granting Moderator rights and permissions.
            </p>
            <p>
                Group ID 1 is associated with the <strong>Client</strong> role, granting Client rights and permissions.
            </p>
        </div>

        <h1 class="py-2">Grant User Permissions</h1>
        <form method="post" action="index.php?controller=user&action=update">
            <input type="hidden" name="user_id" value="<?php echo $user->user_id; ?>">
            <input type="hidden" name="group_id" value="<?php echo $user->group_id; ?>">

            <div class="form-group row justify-content-center">
                <label for="group_id" class="col-sm-2 col-form-label text-left">User ID:</label>
                <div class="col-sm-4">
                    <label><?php echo $user->user_id; ?></label>
                </div>
            </div>

            <div class="form-group row justify-content-center">
                <label for="group_id" class="col-sm-2 col-form-label text-left">Full Name:</label>
                <div class="col-sm-4">
                    <label><?php echo $user->fname; ?> <?php echo $user->lname; ?></label>
                </div>
            </div>

            <div class="form-group row justify-content-center">
                <label for="group_id" class="col-sm-2 col-form-label text-left">Group ID:</label>
                <div class="col-sm-4">
                    <label><?php echo $user->group_id; ?></label>
                </div>
            </div>

            <!-- Group Dropdown -->
            <div class="form-group row justify-content-center">
                <label for="group_id" class="col-sm-2 col-form-label text-left">Role:</label>
                <div class="col-sm-4">
                    <select id="group_id" name="group_id" required class="form-control">
                        <?php
                        // Fetch all groups from the Group table
                        $sql = "SELECT GROUP_ID, GROUP_NAME FROM `GROUP`";
                        $result = $conn->query($sql);

                        // Display the groups as dropdown items
                        $defaultGroupDisplayed = false; // Flag to track if the default group has been displayed

                        if ($result && $result->num_rows > 0) { // Check if the query was successful
                            while ($row = $result->fetch_assoc()) {
                                $group_id = $row['GROUP_ID'];
                                $group_name = $row['GROUP_NAME'];

                                // Check if the group is the default and has not been displayed yet
                                if ($user->group_id == $group_id && !$defaultGroupDisplayed) {
                                    echo "<option value='$user->group_id' selected>$group_name</option>";
                                    $defaultGroupDisplayed = true;
                                } else {
                                    echo "<option value='$group_id'>$group_name</option>";
                                }
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group row justify-content-center">
                <div class="col-sm-6">
                    <button type="submit" class="btn btn-primary" name="update">UPDATE</button>
                    <button type="button" class="btn btn-primary" name="back" onclick="window.history.back();">GO BACK</button>
                </div>
            </div>
        </form>
    </div>

    <footer>
        <?php include_once __DIR__ . "/../../footer.html"; ?>
    </footer>
</body>

</html>
