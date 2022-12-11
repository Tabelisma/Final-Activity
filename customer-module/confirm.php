<?php
    session_start();
    if(!isset($_SESSION['cartItems']) )
        header("Location: index.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/login.css">
    <title>Product Added</title>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="mt-5">
            <h3 class="h3 d-inline mt-5"><i class="fa-solid fa-shop"></i> Learn IT Online Shop </h3>
            <div class="d-inline float-right ">
                <a href="cart.php" class="btn btn-primary btn-sm mt-1">
                    <i class="fa-solid fa-cart-shopping"></i>
                    Cart <span class="badge badge-light"><?php echo isset($_SESSION['cartItems'])? count($_SESSION['cartItems']): '0' ?></span>
                    <span class="sr-only">Unread messages</span>
                </a>
            </div>
        </div>
        <hr>
        <h5>Product Successfully Added to the Cart, What do you want do next?</h5>
        <div class="my-3">
            <a href="cart.php" class="btn btn-dark">
                <i class="fa-solid fa-cart-shopping"></i>
                View Cart
            </a>
            <a href="index.php" class="btn btn-danger">
                <i class="fa-solid fa-bag-shopping"></i>
                Continue Shopping
            </a>
        </div>    

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

</body>
</html>