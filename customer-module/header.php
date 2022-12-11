<?php
    if(isset($_POST['btnLogout'])){
        session_destroy();
        header("Location: ../");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/login.css">
    <title>Product Remove</title>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="mt-5">
            <h3 class="h3 d-inline mt-5"><i class="fa-solid fa-shop"></i> Learn IT Online Shop </h3>
            <div class="d-inline float-right ">
            <a href="cart.php" name="btnCart" class="btn btn-primary btn-sm mt-1">
                <i class="fa-solid fa-cart-shopping"></i>
                Cart <span class="badge badge-light"><?php echo isset($_SESSION['cartItems'])? count($_SESSION['cartItems']): '0' ?></span>
                <span class="sr-only">unread messages</span>
            </a>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary btn-sm mt-1" data-toggle="modal" data-target="#exampleModal">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Do you want to signout?
                            </div>
                            <div class="modal-footer">
                            <form action="" method="post">
                                    <button type="submit" name="btnLogout" class="btn btn-secondary">Yes</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                            </form>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <hr>