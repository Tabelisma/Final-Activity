<?php
    session_start();
    require("../functions.php");

    $arrRecProducts = [];
    if(!isset($_GET['pid'])) {
        header("Location: index.php");
    }
    else{
        $con = openConnection();
        $id = $_GET['pid'] ;
        $strSQL = "SELECT * FROM tbl_products WHERE id = $id ";
        $arrRecProducts = getRecord($con, $strSQL);
        closeConnections($con);
    }

    if(isset($_POST['btnConfirm'])){
        $CarCount = $_SESSION['cartCount'];
        $isDuplicate = false;
        // Duplication Process
        foreach($_SESSION['cartItems'] as $key => $value){
            print_r($_SESSION['cartItems']);
            if($_POST['radSize'] == $_SESSION['cartItems'][$key]['size'] && $_GET['pid'] == $_SESSION['cartItems'][$key]['id']){
                $isDuplicate = true;
                // I forgot change $CarCount into $key
                $_SESSION['cartItems'][$key]['qty'] = $_POST['inputQTY'];
                break;
            }
        }

        if($isDuplicate !== true){
            $CarCount++;        
            $_SESSION['cartItems'][$CarCount]['id'] = $_GET['pid'];
            $_SESSION['cartItems'][$CarCount]['size'] = $_POST['radSize'];
            $_SESSION['cartItems'][$CarCount]['qty'] = $_POST['inputQTY'];
            $_SESSION['cartCount'] = $CarCount;   
        }
  
        header("Location: confirm.php");
    }
    else if(isset($_POST['btnCancel'])){
        header("Location: index.php");
    }
?>

<?php require("header.php");?>

        <div class="row">
            <div class="col-md-5 col-sm-7 col-12">
                <div class="product-grid2 card">
                    <div class="product-image2">
                        <img class="pic-1" src="../img/<?php echo $arrRecProducts[0]['photo1'];?>">
                        <img class="pic-2" src="../img/<?php echo $arrRecProducts[0]['photo2'];?>">
                    </div>
                </div>
            </div>
            <div class="col-md-7 col-sm-5 col-12">
                <h4 class="h4 d-inline py-5"><?php echo $arrRecProducts[0]['name'];?>
                    <span class="badge badge-dark">₱ <?php echo $arrRecProducts[0]['price'];?></span>
                </h4>
                <p class="my-3"><?php echo $arrRecProducts[0]['description'];?></p>
                <hr>
                <form action="" method="post" class="form-group">
                    <h5>Select Size</h5>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radSize" id="rad40" value="40" checked><label class="form-check-label pr-4" for="radXS">40</label>
                        <input class="form-check-input" type="radio" name="radSize" id="rad41" value="41"><label class="form-check-label pr-4" for="radSM">41</label>
                        <input class="form-check-input" type="radio" name="radSize" id="rad42" value="42"><label class="form-check-label pr-4" for="radMD">42</label>
                        <input class="form-check-input" type="radio" name="radSize" id="rad43" value="43"><label class="form-check-label pr-4" for="radLG">43</label>
                        <input class="form-check-input" type="radio" name="radSize" id="rad44" value="44"><label class="form-check-label pr-4" for="radXL">44</label>
                    </div>
                    <hr>
                    <h5>Enter Quantity:</h5>
                    <input class="form-control" name="inputQTY" type="number" min="1" max="100" value="1">
                    <div class="my-3">
                        <button name="btnConfirm"class="btn btn-dark">
                            <i class="fa-solid fa-circle-check"></i>
                            Confirm Product Purchase
                        </button>
                        <button name="btnCancel" class="btn btn-danger">Cancel/Go Back</button>
                    </div>
                </form>


    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

</body>
</html>