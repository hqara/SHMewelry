<?php
// Include the database connection file
include_once(__DIR__ . "/db_connection.php");

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
var_dump($_SESSION);
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
                    <a style="text-decoration: none; color: black; padding: 10px; text-align: center; font-family: 'Lucida Handwriting', Times, serif; font-weight: bold;" href="index.php?controller=home&action=index">
                        SHMewelry
                    </a>
                </h1>
            </div>
            <div class="right-box">
                <table>
                    <tr>
                        <script>
                            function updateAction() {
                                var lookupValue = document.getElementById('lookup').value;
                                var form = document.getElementById('searchForm');
                                form.action = 'index.php?controller=product&action=search&query=' + encodeURIComponent(lookupValue);
                            }
                        </script>

                        <form id="searchForm" onsubmit="updateAction()" method="post">
                            <td>
                                <input type="text" name="lookup" id="lookup" value="" placeholder="Search">
                            </td>
                            <td>
                                <button type="submit" name="search" class="searchIcon"><i class="fa fa-search"></i></button>
                            </td>
                        </form>

                        <td>
                            <button name="cartButton" <?php echo $isLoggedIn ? 'onclick="redirectToCart()"' : 'disabled'; ?>><i class="fa fa-shopping-cart"></i></button>
                        </td>
                        <td class="dropdown profile-dropdown">
                            <button name="profileButton" id="profileButton" <?php echo $isLoggedIn ? 'onclick="redirectToProfile()"' : 'onclick="openLoginPage()"'; ?>>
                                <i class="fa fa-user-circle"></i>
                            </button>
                            <script>
                                function redirectToCart() {
                                    window.location.href = 'index.php?controller=user&action=cart';
                                }

                                function redirectToProfile() {
                                    window.location.href = 'index.php?controller=login&action=login';
                                }

                                function openLoginPage() {
                                    console.log('Opening login page');
                                    window.location.href = 'index.php?controller=login&action=login';
                                }
                            </script>
                            <div class="dropdown-content">
                                <a class="profile" href="index.php?controller=user&action=read">My Profile</a>
                                <a class="profile" href="index.php?controller=orders&action=list">Manage Orders/My Orders</a>
                                <a class="profile" href="index.php?controller=product&action=list">Manage Products</a>
                                <a class="profile" href="index.php?controller=user&action=list">Manage Users and Permissions</a>
                                <a class="profile" href="index.php?controller=user&action=exit">Logout</a>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </header>
    <nav>
        <table>
            <tr>
                <td><a class="dropdown-home" href="index.php?controller=home&action=index">Home</a></td>
                <td class="dropdown">
                    <a href="index.php?controller=product&action=read&type=bracelet">Bracelets &#9662;</a>
                    <div class="dropdown-content">
                        <a href="index.php?controller=product&action=read&type=bracelet"> All Bracelets</a>
                        <?php
                        global $conn;
                        // Fetch unique materials from the Product table
                        $sql = "SELECT DISTINCT Material FROM product";
                        $result = $conn->query($sql);

                        // Display the materials as dropdown items
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<a href='index.php?controller=product&action=read&type=bracelet&material={$row["Material"]}'>" . $row["Material"] . "</a>";
                            }
                        }
                        ?>
                    </div>
                </td>
                <td class="dropdown">
                    <a href="index.php?controller=product&action=read&type=ring">Rings &#9662;</a>
                    <div class="dropdown-content">
                        <a href='index.php?controller=product&action=read&type=ring'>All Rings</a>
                        <?php

                        // Fetch unique materials from the Product table
                        $sql = "SELECT DISTINCT Material FROM product";
                        $result = $conn->query($sql);

                        // Display the materials as dropdown items
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<a href='index.php?controller=product&action=read&type=ring&material={$row["Material"]}'>" . $row["Material"] . "</a>";
                            }
                        }
                        ?>
                    </div>
                </td>
                <td class="dropdown">
                    <a href="index.php?controller=product&action=read&type=necklace">Necklaces &#9662;</a>
                    <div class="dropdown-content">
                        <a href='index.php?controller=product&action=read&type=necklace'>All Necklaces</a>
                        <?php

                        // Fetch unique materials from the Product table
                        $sql = "SELECT DISTINCT Material FROM product";
                        $result = $conn->query($sql);

                        // Display the materials as dropdown items
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<a href='index.php?controller=product&action=read&type=necklace&material={$row["Material"]}'>" . $row["Material"] . "</a>";
                            }
                        }
                        ?>
                    </div>
                </td>
                <td class="dropdown">
                    <a href="index.php?controller=product&action=read&type=earring">Earrings &#9662;</a>
                    <div class="dropdown-content">
                        <a href='index.php?controller=product&action=read&type=earring'>All Earrings</a>
                        <?php

                        // Fetch unique materials from the Product table
                        $sql = "SELECT DISTINCT Material FROM product";
                        $result = $conn->query($sql);

                        // Display the materials as dropdown items
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<a href='index.php?controller=product&action=read&type=earring&material={$row["Material"]}'>" . $row["Material"] . "</a>";
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
