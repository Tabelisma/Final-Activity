<?php
    if(isset($_GET['k'])){
        require('../functions.php');
        $con = openConnection();
        $strSQL = "
            DELETE FROM tbl_products
            WHERE id = " . $_GET['k'];
    
        if(mysqli_query($con, $strSQL))
            header("location: products.php");
        else
            $arrError[] = 'Error: Failed Delete SQL';
        closeConnections($con);
    }
    header("Location: products.php");

    
?>