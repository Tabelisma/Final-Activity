<?php
    session_start();
    require("../functions.php");
  $amount = 0;
    $itemQTYCount = 0;
    $itemID = 0;
    $itemSize = "";
    $itemQty = 0;
    $itemTotal = 0;

    if(isset($_POST['btnUpdate'])){
        foreach($_POST['numQTY'] as $key => $value){
            $_SESSION['cartItems'][$key + 1]['qty'] = $value;
        }
    }

    if(isset($_POST['btnCheckout'])){
        session_destroy();
        header("Location: clear.php");
    }

?>
<?php require("header.php");?>

        <!-- Tables -->
        <div class="row mt-3">
            <div class="col-12">
            <form action="" method="post">
                <div class="table-responsive">
                    <?php if(isset($_SESSION['cartItems']) > 0 && count($_SESSION['cartItems']) != 0):?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col"> </th>
                                    <th scope="col">Product</th>
                                    <th scope="col" class="text-center">Size</th>
                                    <th scope="col" class="text-center">Quantity</th>
                                    <th scope="col" class="text-center">Price</th>
                                    <th scope="col" class="text-center">Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($_SESSION['cartItems'] as $CartKey => $CartValue):
                                        $con = openConnection();
                                        $itemID = $_SESSION['cartItems'][$CartKey]['id'];
                                        $strSQL = "SELECT * FROM tbl_products WHERE id = $itemID ";
                                        $arrRecProducts = getRecord($con, $strSQL);
                                        $itemSize =  $_SESSION['cartItems'][$CartKey]['size'];
                                        $_SESSION['itemQty'][$CartKey] = $_SESSION['cartItems'][$CartKey]['qty'];
                                        $itemQty = $_SESSION['cartItems'][$CartKey]['qty'];                                       
                                        $itemTotal = $arrRecProducts[0]['price'] * $itemQty;
                                        $amount += $itemTotal;
                                        $itemQTYCount += $itemQty;
                                        closeConnections($con);

                                ?>
                                    <tr>
                                        <td><img style="width: 2em" src="../img/<?php echo  $arrRecProducts[0]['photo1']?>"/></td>
                                        <td><?php echo $arrRecProducts[0]['name']?></td>
                                        <td class="text-center"><?php echo $itemSize;?></td>
                                        <td class="text-center"><input class="text-center" name="numQTY[]" class="form-control text-center" type="number" min="1" max="100" value="<?php echo $itemQty;?>"></td>
                                        <td class="text-center" >₱ <?php echo number_format($arrRecProducts[0]['price']);?></td>
                                        <td class="text-center">₱ <?php echo number_format($itemTotal);?></td>
                                        <td class="text-center"><a class="btn btn-sm btn-danger" href="remove-confirm.php?cartno=<?php echo $CartKey;?>&qt=<?php echo $itemQty;?>"><i class="fa fa-trash"></i> </a> </td>
                                    </tr>
                                <?php endforeach;?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="text-center"><strong>Total</strong></td>
                                    <td class="text-center"><?php echo isset($_SESSION['cartItems'])? count($_SESSION['cartItems']): '0'?></td>
                                    <td class="text-center">----</td>
                                    <td class="text-center"><strong>₱ <?php echo number_format($amount);?></strong></td>
                                    <td class="text-center">----</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Footer button -->
                    <div class="col mb-2">
                        <div class="row">
                            <div class="col-sm-12  col-md-4">
                                <a href="index.php" class="btn btn-block btn-danger">
                                    <i class="fa-solid fa-bag-shopping"></i>
                                    Continue Shopping
                                </a>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <button type="submit" href="cart.php?" name="btnUpdate" href="cart.php" name ="clickUpdate" class="btn btn-block btn-success">
                                    <i class="fa-solid fa-pen-to-square"></i>                          
                                    Update Cart
                                </button>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <button name="btnCheckout" href="clear.php" class="btn btn-lg btn-block btn-info">
                                    <i class="fa-solid fa-right-to-bracket"></i>
                                    Checkout
                                </button>
                            </div>
                        </div>
                    </div>
            </form>
            <?php else: ?> 
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">Product</th>
                            <th scope="col" class="text-center">Size</th>
                            <th scope="col" class="text-center">Quantity</th>
                            <th scope="col" class="text-right">Price</th>
                            <th scope="col" class="text-right">Total</th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Cart is Empty</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <div class="col-sm-12  col-md-4">
                    <a href="index.php" class="btn btn-block btn-danger">
                        <i class="fa-solid fa-bag-shopping"></i>
                        Continue Shopping
                    </a>
                </div>


            <?php endif; ?>  
            
        </div>
    </div>
                                
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

</body>
</html>