<?php
// Include the database connection file
include_once(__DIR__ . "/db_connection.php");

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>SHMewelry</title>

    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        header, footer {
            flex-shrink: 0; 
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
        }

        header {
            background-color: #fff;
            color: #333;
            padding: 10px;
        }

        a {
            text-decoration: no-underline;
        }

        nav, nav .dropdown {
            background-color: #fff;
            padding: 10px;
            text-align: center;
            position: initial;
            z-index: 100;
        }

        nav a {
            margin-right: 20px;
            text-decoration: none;
            color: #808080;
            font-weight: bold;
            transition: color 0.3s;
        }

        nav a:hover {
            color: #6ac5fe;
            position: relative;
            z-index: 1;
        }

        section {
            padding: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 10px;
        }

        .wider-column {
            width: 80%;
        }

        .wider-column2 {
            width: 1050px;
        }

        section {
            background-color: #6ac5fe;
            padding: 3px;
        }

        a {
            text-decoration: none;
            color: black;
        }

        a:active, a:focus {
            color: black;
        }

    
        .dropdown, .dropdown button {
            position: relative;
            z-index: 1;
        }


        .dropdown-content, button .dropdown-content {
            top: 100%; 
            display: none;
            position: absolute;
            background-color: #fff;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            min-width: 160px; 
            z-index: 2;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-content a {
            display: block;
            width: 100%;
            padding: 10px;
            text-decoration: none;
            margin-right: 20px;
            color: #808080;
            font-weight: bold;
            transition: color 0.3s;
        }

        .dropdown-content a:hover {
            color: #6ac5fe;
            position: relative;
            transition: color 0.3s;
        }


    </style>

</head>

<body>

    <header>
        <div>
            <table>
                <tr>
                    <td class="wider-column">
                        <h1><a href="index.php?controller=home&action=index">SHMewelry</a></h1>
                    </td>

                    <td>
                        <input type="text" name="searchQuery" placeholder="Search">
                        <button type="submit" class="searchIcon"><i class="fa fa-search"></i></button>
                        <button name="cartButton" <?php echo $isLoggedIn ? '' : 'disabled'; ?>><i class="fa fa-shopping-cart"></i></button>
                    

                    <div class="dropdown">
                            <button name="profileButton" id="profileButton" <?php echo $isLoggedIn ? 'onclick="redirectToProfile()"' : 'onclick="openLoginPage()"'; ?>>
                                <i class="fa fa-user-circle"></i>
                            </button>
                    
                        <script>
                            function redirectToProfile() {
                                // Replace 'profile.php' with the actual path to the user profile page
                                window.location.href = '../../../../SHMewelry/Views/Login/login.php';
                                //window.location.href = 'index.php?controller=home&action=login'; 
                            }

                            function openLoginPage() {
                                console.log('Opening login page');
                                // Replace 'login.php' with the actual path to the login page
                                window.location.href = 'index.php?controller=login&view=login';
                                //window.location.href = 'index.php?controller=home&action=login';  //   MODIFY
                            }
                        </script>
                        <div class="dropdown-content">
                            <a href="index.php?controller=user&action=read">My Profile</a>
                            <a href="index.php?controller=orders&action=list">Manage Orders/My Orders</a>
                            <a href="index.php?controller=product&action=list">Manage Products</a>
                            <a href="index.php?controller=user&action=list">Manage Users and Permissions</a>
                            <a href="index.php?controller=user&action=exit">Logout</a>
                        </div>
                        </div>
                    </td>
                </tr>
            </table>
    </header>

    <nav>
        <table>
            <tr>
                <td><a href="index.php?controller=home&view=index">Home</a></td>
                <td class="dropdown">
                    <a href="index.php?controller=home&view=list&type=bracelet">Bracelets &#9662;</a>
                    <div class="dropdown-content">
                        <a href="index.php?controller=home&view=list&type=bracelet"> All Bracelets</a>
                        <?php
                        global $conn;
                        // Fetch unique materials from the Product table
                        $sql = "SELECT DISTINCT Material FROM product";
                        $result = $conn->query($sql);

                        // Display the materials as dropdown items
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<a href='index.php?controller=home&type=bracelet&view=list&material={$row["Material"]}'>" . $row["Material"] . "</a>";
                            }
                        }
                        ?>
                    </div>
                </td>
                <td class="dropdown">
                    <a href="index.php?controller=home&view=list&type=ring">Rings &#9662;</a>
                    <div class="dropdown-content">
                        <a href='index.php?controller=home&view=list&type=ring'>All Rings</a>
                        <?php

                        // Fetch unique materials from the Product table
                        $sql = "SELECT DISTINCT Material FROM product";
                        $result = $conn->query($sql);

                        // Display the materials as dropdown items
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<a href='index.php?controller=home&type=ring&view=list&material={$row["Material"]}'>" . $row["Material"] . "</a>";
                            }
                        }
                        ?>
                    </div>
                </td>
                <td class="dropdown">
                    <a href="index.php?controller=home&view=list&type=necklace">Necklaces &#9662;</a>
                    <div class="dropdown-content">
                        <a href='index.php?controller=home&view=list&type=necklace'>All Necklaces</a>
                        <?php

                        // Fetch unique materials from the Product table
                        $sql = "SELECT DISTINCT Material FROM product";
                        $result = $conn->query($sql);

                        // Display the materials as dropdown items
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<a href='index.php?controller=home&type=necklace&view=list&material={$row["Material"]}'>" . $row["Material"] . "</a>";
                            }
                        }
                        ?>
                    </div>
                </td>
                <td class="dropdown">
                    <a href="index.php?controller=home&view=list&type=earring">Earrings &#9662;</a>
                    <div class="dropdown-content">
                        <a href='index.php?controller=home&view=list&type=earring'>All Earrings</a>
                        <?php

                        // Fetch unique materials from the Product table
                        $sql = "SELECT DISTINCT Material FROM product";
                        $result = $conn->query($sql);

                        // Display the materials as dropdown items
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<a href='index.php?controller=home&type=earring&view=list&material={$row["Material"]}'>" . $row["Material"] . "</a>";
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
