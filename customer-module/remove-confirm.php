<?php
    session_start();
    require("../functions.php");

    $arrRecProducts = [];
    if(!isset($_GET['cartno'])) {
        header("Location: cart.php");
    }
    else{
        $cartNo = $_GET['cartno'];
        $itemID = $_SESSION['cartItems'][$cartNo]['id'];
        $itemSize =  $_SESSION['cartItems'][$cartNo]['size'];
        $itemQty = $_SESSION['cartItems'][$cartNo ]['qty'];
        $con = openConnection();
        $strSQL = "SELECT * FROM tbl_products WHERE id = $itemID";
        $arrRecProducts = getRecord($con, $strSQL);
        closeConnections($con);
    }

    if ((isset($_SESSION['cartItems'])? count($_SESSION['cartItems']): '0') === '0'){
        unset($_SESSION['cartItems']);
    }


    if(isset($_POST['btnRemove'])){
        unset($_SESSION['cartItems'][$cartNo]);
        $_SESSION['cartCount'] -= 1; // I forgot to put this for subration of cart count every removed an item
        header("Location: cart.php");
    }
    else if (isset($_POST['btnCancel']))
        header("Location: cart.php");
    
?>
<?php require("header.php");?>
        <div class="row">
            <div class="col-md-5 col-sm-7 col-12">
                <div class="product-grid2 card">
                    <div class="product-image2">
                        <a href="#">
                            <img class="pic-1" src="../img/<?php echo  $arrRecProducts[0]['photo1']?>">
                            <img class="pic-2" src="../img/<?php echo $arrRecProducts[0]['photo2']?>">
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-7 col-sm-5 col-12">
                <h4 class="h4 d-inline py-5"><?php echo $arrRecProducts[0]['name']?>
                    <span class="badge badge-dark">₱ <?php echo $arrRecProducts[0]['price']?></span>
                </h4>
                <p class="mt-3"><?php echo $arrRecProducts[0]['description']?></p>
                <hr>
                <h5>Size: <?php echo $itemSize;?></h5>

                <hr>
                <h5>Quantity: <?php echo $_GET['qt']?></h5>
                <form action="" method="post">
                    <div class="my-3">
                        <button name="btnRemove" class="btn btn-dark">
                            <i class="fa-solid fa-circle-check"></i>
                            Confirm Product Remove
                        </button>
                        <button name="btnCancel" class="btn btn-danger">Cancel/Go Back</button>
                    </div>
                </form>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

</body>
</html>