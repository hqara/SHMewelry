<?php    
    // Check if the user is logged in
    $isLoggedIn = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     
    <style>
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

nav {
    background-color: #fff;
    padding: 10px;
    text-align: center;
    position: relative;
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
    width: 900px;
}

.wider-column2 {
    width: 1050px;
}

section {
    background-color: #6ac5fe;
    padding: 3px;
}

.dropdown {
    position: relative;
    
    z-index: 1;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #fff;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    
}

.dropdown:hover .dropdown-content {
    display: block;
}

.dropdown-content a {
    display: block;
    padding: 10px;
    text-decoration: none;
    color: #333;
}


    </style>
    
</head>
<body>

    <header>
        

        <div>
            <table >
                <tr>
                    
                    <td class= "wider-column">
                        <h1>SHMewelry</a> </h1>
                    </td>
                   

                    <td>
                        <input type="text" name="searchQuery" placeholder="Search">
                        <button type="submit" class="searchIcon"><i class="fa fa-search"></i></button>
                        
                    
                        <button name="cartButton" <?php echo $isLoggedIn ? '' : 'disabled'; ?>>
                            <i class="fa fa-shopping-cart"></i>
                        </button>
                    
                        <button name="profileButton" id="profileButton" <?php echo $isLoggedIn ? 'onclick="redirectToProfile()"' : 'onclick="openLoginPage()"'; ?>>
                            <i class="fa fa-user-circle"></i>
                        </button>
                        <script>
                            function redirectToProfile() {
                                // Replace 'profile.php' with the actual path to the user profile page
                                window.location.href = '../../../../SHMewelry/Views/Login/login.php';
                            }

                            function openLoginPage() {
                                console.log('Opening login page');
                                // Replace 'login.php' with the actual path to the login page
                                window.location.href = '../../../../SHMewelry/Views/Login/login.php';
                            }
                        </script>
                    </td>
                    
                </tr>
            </table>
        </div>
    </header>

    <nav>
        <table>
            <tr>
                <td><a href="../../../SHMewelry/index.php">Home</a></td>
                <td class="dropdown">
                    <a href="#">Bracelets &#9662;</a>
                    <div class="dropdown-content">
                        <a href="#"> All Bracelets</a>
                        <?php
                            // Include the database connection file
                            include_once("db_connection.php");

                            // Fetch unique materials from the Product table
                            $sql = "SELECT DISTINCT Material FROM product";
                            $result = $conn->query($sql);

                            // Display the materials as dropdown items
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<a href='#'>" . $row["Material"] . "</a>";
                                }
                            }
                        ?>
                    
                    </div>
                </td>
                <td class="dropdown">
                    <a href="#">Rings &#9662;</a>
                    <div class="dropdown-content">
                        <a href="#"> All Rings</a>
                        <?php
                            // Include the database connection file
                            include_once("db_connection.php");

                            // Fetch unique materials from the Product table
                            $sql = "SELECT DISTINCT Material FROM product";
                            $result = $conn->query($sql);

                            // Display the materials as dropdown items
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<a href='#'>" . $row["Material"] . "</a>";
                                }
                            }
                        ?>
                    </div>
                </td>
                <td class="dropdown">
                    <a href="#">Necklaces &#9662;</a>
                    <div class="dropdown-content">
                        <a href="#"> All Necklaces</a>
                        <?php
                            // Include the database connection file
                            include_once("db_connection.php");

                            // Fetch unique materials from the Product table
                            $sql = "SELECT DISTINCT Material FROM product";
                            $result = $conn->query($sql);

                            // Display the materials as dropdown items
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<a href='#'>" . $row["Material"] . "</a>";
                                }
                            }
                        ?>
                    </div>
                </td>
                <td class="dropdown">
                    <a href="#">Earrings &#9662;</a>
                    <div class="dropdown-content">
                        <a href="#"> All Earrings</a>
                        <?php
                            // Include the database connection file
                            include_once("db_connection.php");

                            // Fetch unique materials from the Product table
                            $sql = "SELECT DISTINCT Material FROM product";
                            $result = $conn->query($sql);

                            // Display the materials as dropdown items
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<a href='#'>" . $row["Material"] . "</a>";
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
    
    </br>
    </br>



    

</body>
</html>
