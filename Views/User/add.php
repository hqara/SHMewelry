<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="CSS/shared.css">
</head>

<body>
    <?php include_once __DIR__ . "/../../navbar.php"; ?>

    <div class="container my-5 text-center">
        <h1 class="py-2">Create New User</h1>
        <form method="post" action="index.php?controller=user&action=create">

            <div class="form-group row justify-content-center">
                <label for="fname" class="col-sm-2 col-form-label text-left">First Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="fname" name="fname" autocomplete="off" required>
                </div>
            </div>

            <div class="form-group row justify-content-center">
                <label for="lname" class="col-sm-2 col-form-label text-left">Last Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="lname" name="lname" autocomplete="off" required>
                </div>
            </div>

            <div class="form-group row justify-content-center">
                <label for="email" class="col-sm-2 col-form-label text-left">Email</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="email" name="email" autocomplete="off" required>
                </div>
            </div>

            <div class="form-group row justify-content-center">
                <label for="password" class="col-sm-2 col-form-label text-left">Password</label>
                <div class="col-sm-6">
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" autocomplete="off" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <input type="checkbox" id="showPassword"> Show
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row justify-content-center">
                <label for="group" class="col-sm-2 col-form-label text-left">Group</label>
                <div class="col-sm-6">
                    <select id="group" name="group_id" required class="form-control">
                        <option value="1">Client</option>
                        <option value="2">Moderator</option>
                        <option value="3">Admin</option>
                    </select>
                </div>
            </div>

            <div class="form-group row justify-content-center">
                <div class="col-sm-6 text-center">
                    <button type="submit" class="btn btn-primary" name="create">CREATE</button>
                    <button type="button" class="btn btn-primary" name="back" onclick="window.history.back();">GO BACK</button>
                </div>
            </div>

        </form>
    </div>

    <!-- JavaScript to toggle password visibility -->
    <script>
        document.getElementById('showPassword').addEventListener('change', function () {
            var passwordInput = document.getElementById('password');
            passwordInput.type = this.checked ? 'text' : 'password';
        });
    </script>


     <?php include_once __DIR__ . "/../../footer.html"; ?>

</body>
</html>
