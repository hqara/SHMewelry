<?php
// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user']) && !empty($_SESSION['user']);

// Debugging: Dump the entire user object
if ($isLoggedIn) {
    var_dump($_SESSION['user']);
    // Retrieve the group_id from the user object in the session
    $groupId = $_SESSION['user']->group_id;

    // Now, $groupId contains the value of group_id for the logged-in user
    echo "Group ID: " . $groupId;
} else {
    // User is not logged in
    echo "User is not logged in.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="CSS/shared.css">
    <title>SHMewelry</title>
</head>

<body>
    <header>
        <div class="header-container">
            <div class="left-box">
                <h1>
                    <a style="text-decoration: none; color: #4a8bb4; padding: 10px; text-align: center; font-family: 'Lucida Handwriting', Times, serif; font-weight: bold;" href="?controller=home&action=index">
                        SHMewelry
                    </a>
                </h1>
            </div>
            <div class="right-box">
                <table>
                    <tr>
                        <form id="searchForm" onsubmit="updateAction()" method="post">
                            <td>
                                <input type="text" name="lookup" id="lookup" value="" placeholder="Search">
                            </td>
                            <td>
                                <button type="submit" name="search" class="searchIcon"><i class="fa fa-search"></i></button>
                            </td>
                        </form>

                        <td>
                            <?php if ($isLoggedIn && $groupId === 1): ?>
                                <button name="cartButton" onclick="redirectToCart()"><i class="fa fa-shopping-cart"></i></button>
                            <?php else: ?>
                                <button name="cartButton" disabled><i class="fa fa-shopping-cart"></i></button>
                            <?php endif; ?>
                        </td>
                        <td class="dropdown profile-dropdown">
                            <?php if (!$isLoggedIn): ?>
                                <button name="profileButton" id="profileButton" onclick="openLoginPage()">
                                    <i class="fa fa-user-circle"></i>
                                </button>
                            <?php else: ?>
                                <button name="profileButton" id="profileButton" onclick="redirectToProfile()">
                                    <i class="fa fa-user-circle"></i>
                                </button>
                                <div class="dropdown-content" id="profileDropdown">
                                    <?php if ($groupId === 1): ?>
                                        <a class="profile" href="?controller=user&action=read">My Profile</a>
                                        <a class="profile" href="?controller=orders&action=list">My Orders</a>
                                        <a class="profile" href="?controller=user&action=logout">Logout</a>
                                    <?php elseif ($groupId === 2 ): ?>
                                        <a class="profile" href="?controller=user&action=read">My Profile</a>
                                        <a class="profile" href="?controller=orders&action=list">Manage Orders</a>
                                        <a class="profile" href="?controller=product&action=list">Manage Products</a>
                                        <a class="profile" href="?controller=user&action=logout">Logout</a>
                                    <?php elseif ($groupId === 3): ?>
                                        <a class="profile" href="?controller=user&action=read">My Profile</a>
                                        <a class="profile" href="?controller=orders&action=list">Manage Orders</a>
                                        <a class="profile" href="?controller=product&action=list">Manage Products</a>
                                        <a class="profile" href="?controller=user&action=list">Manage Users and Permissions</a>
                                        <a class="profile" href="?controller=user&action=logout">Logout</a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </header>

    <script>
        function updateAction() {
            var lookupValue = document.getElementById('lookup').value;
            var form = document.getElementById('searchForm');
            form.action = '?controller=product&action=search&query=' + encodeURIComponent(lookupValue);
        }

        function redirectToCart() {
            window.location.href = '?controller=user&action=cart';
        }

        function redirectToProfile() {
            window.location.href = '?controller=user&action=read';
        }


        function openLoginPage() {
            window.location.href = '?controller=user&action=login';
        }

        function toggleDropdown() {
            var dropdown = document.getElementById('profileDropdown');
            dropdown.classList.toggle('show');
        }
    </script>
    <nav>
        <table>
            <tr>
                <td><a class="dropdown-home" href="?controller=home&action=index">Home</a></td>
                <td class="dropdown">
                    <a href="?controller=product&action=read&type=bracelet">Bracelets &#9662;</a>
                    <div class="dropdown-content">
                        <a href="?controller=product&action=read&type=bracelet"> All Bracelets</a>
                        <?php
                        global $conn;
                        // Fetch unique materials from the Product table
                        $sql = "SELECT DISTINCT Material FROM product";
                        $result = $conn->query($sql);

                        // Display the materials as dropdown items
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<a href='?controller=product&action=read&type=bracelet&material={$row["Material"]}'>" . $row["Material"] . "</a>";
                            }
                        }
                        ?>
                    </div>
                </td>
                <td class="dropdown">
                    <a href="?controller=product&action=read&type=ring">Rings &#9662;</a>
                    <div class="dropdown-content">
                        <a href='?controller=product&action=read&type=ring'>All Rings</a>
                        <?php

                        // Fetch unique materials from the Product table
                        $sql = "SELECT DISTINCT Material FROM product";
                        $result = $conn->query($sql);

                        // Display the materials as dropdown items
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<a href='?controller=product&action=read&type=ring&material={$row["Material"]}'>" . $row["Material"] . "</a>";
                            }
                        }
                        ?>
                    </div>
                </td>
                <td class="dropdown">
                    <a href="?controller=product&action=read&type=necklace">Necklaces &#9662;</a>
                    <div class="dropdown-content">
                        <a href='?controller=product&action=read&type=necklace'>All Necklaces</a>
                        <?php

                        // Fetch unique materials from the Product table
                        $sql = "SELECT DISTINCT Material FROM product";
                        $result = $conn->query($sql);

                        // Display the materials as dropdown items
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<a href='?controller=product&action=read&type=necklace&material={$row["Material"]}'>" . $row["Material"] . "</a>";
                            }
                        }
                        ?>
                    </div>
                </td>
                <td class="dropdown">
                    <a href="?controller=product&action=read&type=earring">Earrings &#9662;</a>
                    <div class="dropdown-content">
                        <a href='?controller=product&action=read&type=earring'>All Earrings</a>
                        <?php

                        // Fetch unique materials from the Product table
                        $sql = "SELECT DISTINCT Material FROM product";
                        $result = $conn->query($sql);

                        // Display the materials as dropdown items
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<a href='?controller=product&action=read&type=earring&material={$row["Material"]}'>" . $row["Material"] . "</a>";
                            }
                        }
                        ?>
                    </div>
                </td>
            </tr>
        </table>
    </nav>

    <section>

    </section>
    <br>
    <br>
</body>

</html>
