<?php
    session_start();
    require("../functions.php");
    $con = openConnection();
    $strSQL = "SELECT * FROM tbl_products";
    $arrRecProducts = getRecord($con, $strSQL);
    closeConnections($con);
    
?>
<?php require("header.php");?>
        <div class="row">
            <!-- Products -->
            <?php
                foreach($arrRecProducts as $key => $valueItem):
            ?>
                    <div class="col-md-3 col-sm-6">
                        <div class="product-grid2 card mb-5">
                            <div class="product-image2">
                                <a name="btnDetails" href="./detail.php?pid=<?php echo $valueItem['id'];?>">
                                    <img class="pic-1" src="../img/<?php echo $valueItem['photo1'];?>">
                                    <img class="pic-2 h-100" src="../img/<?php echo $valueItem['photo2'];?>">
                                </a>
                            </div>
                            <div class="product-content">
                                <h3 class="title d-inline"><?php echo $valueItem['name'];?><br>
                                    <span class="badge badge-dark">₱<?php echo $valueItem['price'];?></span>
                                </h3>
                            </div>
                        </div>
                    </div>
            <?php            
                endforeach;
            ?>
    </div>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

</body>
</html>