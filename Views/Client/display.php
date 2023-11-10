<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud operations</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../style.css">
    <header>
    <?php include('../../navbar.php'); ?>
    </header>
</head>
<body>
    <div class="container">
        <div class="row">
            <h2>Featured Products</h2>
        </div>
        <div class="row">
            <div class="col-md 3">
                <div class="product-box">
                    <div class="product-inner-box position-relative">
                        <div class="icons">
                            <a href="#" class="text-decoration-none text-dark">
                                <i class="fas fa-heart"></i>
                            </a>
                            <a href="#" class="text-decoration-none text-dark">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                        <div class="onsale position-absolute top-0 start-0">
                            <span class="badg rounded-0"><i class="fal fa-long-arrow-down"></i></span>
                        </div>
                        <img src="../../app/images/bracelet1.jpeg" alt="bracelet1" class="img-fluid">
                        <div class="cart-btn">
                            <button class="btn btn-white shadow-sm rounded-pill" name="bracelet1"><i class="fal fa-shopping-cart"></i> Add to Cart</button>
                        </div>
                    </div>
                </div>
                <div class="product-info">
                    <div class="product-name">
                        <h3>Bracelet Dummy 1</h3>
                    </div>
                    <div class="product-price">
                        $<span>179</span>
                    </div>
                </div>
            </div>
            <div class="col-md 3">
                <div class="product-box">
                    <div class="product-inner-box position-relative">
                        <div class="icons">
                            <a href="#" class="text-decoration-none text-dark">
                                <i class="fas fa-heart"></i>
                            </a>
                            <a href="#" class="text-decoration-none text-dark">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                        <div class="onsale position-absolute top-0 start-0">
                            <span class="badg rounded-0"><i class="fal fa-long-arrow-down"></i></span>
                        </div>
                        <img src="../../app/images/bracelet1.jpeg" alt="bracelet2" class="img-fluid">
                        <div class="cart-btn">
                            <button class="btn btn-white shadow-sm rounded-pill" name="bracelet2"><i class="fal fa-shopping-cart"></i> Add to Cart</button>
                        </div>
                    </div>
                </div>
                <div class="product-info">
                    <div class="product-name">
                        <h3>Bracelet Dummy 2</h3>
                    </div>
                    <div class="product-price">
                        $<span>179</span>
                    </div>
                </div>
            </div>
            <div class="col-md 3">
                <div class="product-box">
                    <div class="product-inner-box position-relative">
                        <div class="icons">
                            <a href="#" class="text-decoration-none text-dark">
                                <i class="fas fa-heart"></i>
                            </a>
                            <a href="#" class="text-decoration-none text-dark">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                        <div class="onsale position-absolute top-0 start-0">
                            <span class="badg rounded-0"><i class="fal fa-long-arrow-down"></i></span>
                        </div>
                        <img src="../../app/images/bracelet1.jpeg" alt="bracelet3" class="img-fluid">
                        <div class="cart-btn">
                            <button class="btn btn-white shadow-sm rounded-pill" name="bracelet3"><i class="fal fa-shopping-cart"></i> Add to Cart</button>
                        </div>
                    </div>
                </div>
                <div class="product-info">
                    <div class="product-name">
                        <h3>Bracelet Dummy 3</h3>
                    </div>
                    <div class="product-price">
                        $<span>179</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (optional, for Bootstrap components) -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
<footer>
    <?php
        include_once("../../footer.html");
    ?>
</footer>
</html>
