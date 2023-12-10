<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    
     <!-- Bootstrap CSS -->
     <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include_once(__DIR__ . "/../../navbar.php"); ?>

    <center>
        <table style="background-color: #e6f3f8; width: 70%; height: auto; padding:25px">
            <tr>
                <th><img src="/../SHMewelry/assets/images/AboutUs2.jpg" height="390"></th>
                <td>
                    <h1>About Us</h1>
                    <p>Welcome to SHMewelry, where timeless elegance meets modern sophistication. We're your go-to destination for exquisite jewelry that celebrates life's moments with grace.</p>
                    <p>At SHMewelry, our curated collection blends classic and contemporary designs, crafted with precision and attention to detail. Each piece is a testament to our commitment to quality craftsmanship, using only the finest materials to create jewelry that stands the test of time.</p>
                    <p>Why choose SHMewelry? We offer a personalized shopping experience, ensuring you find the perfect piece that resonates with your style. Our secure platform allows you to shop with confidence, and we take pride in being part of your journey, celebrating every milestone with you.</p>
                    <p>Explore the artistry, elegance, and enduring beauty of SHMewelry. Thank you for choosing us for your jewelry needs.</p>
                </td>
            </tr>
        </table>
    </center>

    <center>
        <div class="container" style="display:block; padding:10px; width: 70%">
            <form action="#" method="post">
                <table>
                    <tr>

                        <th colspan="2"><h1>Contact Us</h1></th>
                        <td></td>
                        <td rowspan="8"><img src="/../SHMewelry/assets/images/AboutUs.jpg" height="415" margin-top="20px"></td>
                    </tr>
                    <tr>
                        <td>First Name:</td>
                        <td>Last Name:</td>
                    </tr>
                    <tr>
                        <td><input type="text" name="firstName" size="40"></td>
                        <td><input type="text" name="lastName" size="40"></td>
                    </tr>
                    <tr>
                        <td>Email:</td>

                    </tr>
                    <tr>
                        <td colspan="2"><input style="width: 100%" type="email" name="email" size="115"></td>

                    </tr>
                    <tr>
                        <td>Message:</td>
                    </tr>
                    <tr>
                        <td colspan="2"><textarea style="width: 100%" name="message" rows="5" cols="106"></textarea></td>
                    </tr>

                    <tr>
                        <td colspan="2"><input type="submit" value="Send Message" style="width: 100%;height: 40px; background-color: #6ac5fe; color:#fff;border: 1px solid transparent;"></td>
                    </tr>
                </table>
            </form>
        </div>
    </center>

    <?php include_once(__DIR__ . "/../../footer.html"); ?>

</body>
</html>
