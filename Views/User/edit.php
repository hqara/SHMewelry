
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <header>
        <?php include('../../navbar.php'); ?>
    </header>
</head>

<body>
    <div class="container my-5 text-center">
        <h1 class="py-4">Edit User ID=<?php echo $user->user_id; ?> Permissions</h1>
        <form method="post"  action="index.php?controller=user&action=update">
        <input type="hidden" name="user_id" value="<?php echo $user->user_id; ?>">

        <div class="form-group row justify-content-center">
            <label for="group_id" class="col-sm-2 col-form-label text-left">Group ID</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="group_id" name="group_id" autocomplete="off" value="<?php echo $user->group_id; ?>">
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

</body>

<footer>
    <?php
    include_once("../../footer.html");
    ?>
</footer>

</html>
