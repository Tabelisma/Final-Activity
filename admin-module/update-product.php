<?php
    session_start();
    $_SESSION['CURR_PAGE'] = 'products';
?>
<?php require_once("header.php") ?>
<?php
    if(isset($_GET['k'])){
        $_SESSION['k'] = $_GET['k'];
    }
    $con = openConnection();
    $strSQL = "SELECT * FROM tbl_products WHERE id = ".  $_SESSION['k'];
    $recPersons = getRecord($con, $strSQL);

    if(isset($_POST['btnUpdate'])){
        $product_name = sanitizeInputs($con, $_POST['txtProductName']);
        $product_description = sanitizeInputs($con, $_POST['txtProductDesc']);
        $product_price = sanitizeInputs($con, $_POST['txtProductPrice']);
        $photo1 = "";
        $photo2 = "";
        $arrError = [];

        // File 
        $arrAllowFiles = ['jpeg', 'jpg', 'png'];
        $uploadDIR = 'img/';

        if(isset($_FILES['filePhoto1'])){
            $arrErrorFile1 =  [];
            $fileName1 = $_FILES['filePhoto1']['name'];
            $fileSize1 = $_FILES['filePhoto1']['size'];
            $fileTemp1 = $_FILES['filePhoto1']['tmp_name'];
            $fileType1 = $_FILES['filePhoto1']['type'];

            $fileExtTemp1 = explode('.', $fileName); // thi become the array
            $fileExt1 = strtolower(end($fileExtTemp)); 

            if(in_array($fileExt1, $arrAllowFiles) === false){
                $arrErrorFile1[] = "Photo 1: Extension File is not allowed, You can only choose a JPG or PNG file"; 
            }
            if(empty($arrErrorFile1)){
                $photo1 = $fileName1;
                move_uploaded_file($fileTemp1, $uploadDIR , $fileName1);
            }

        }

        if(isset($_FILES['filePhoto2'])){
            $arrErrorFile2 = [];
            $fileName2 = $_FILES['filePhoto2']['name'];
            $fileSize2 = $_FILES['filePhoto2']['size'];
            $fileTemp2 = $_FILES['filePhoto2']['tmp_name'];
            $fileType2 = $_FILES['filePhoto2']['type'];

            $fileExtTemp2 = explode('.', $fileName); // this become the array
            $fileExt2 = strtolower(end($fileExtTemp)); 

            if(in_array($fileExt2, $arrAllowFiles) === false){
                $arrErrorFile2[] = "Photo 2: Extension File is not allowed, You can only choose a JPG or PNG file"; 
            }
            if(empty($arrErrorFile2)){
                $photo2 = $fileName2;
                move_uploaded_file($fileTemp2, $uploadDIR , $fileName2);
            }
        }

        if(empty($product_name))
            $arrError[] = "Product Name is Required";
        
        if(empty($product_description))
            $arrError[] = "Product Description is Required";

        if(empty($product_price))
            $arrError[] = "Photo 1 Address is Required";       

        if(empty($photo2))
            $arrError[] = "Photo 2 is Required";            

                // Next time tuloy mo yun arrError printing

        if(empty($arrError)){
            require('open_connection.php');
            // Inserting Multiple Rows
            $strSQL = "
                UPDATE tbl_products SET 
                    name =  '$lastname', 
                    description = '$firstname', 
                    price = '$sex', 
                    photo1 = '$email'
                    photo2 = '$email'
                WHERE id = " . $_SESSION['k'];

            if(mysqli_query($con, $strSQL)){
                unset($_SESSION['k']);
                header("location: person.php");
                mysqli_free_result();
            }

            else{
                $arrError[] = 'Error: Failed Update SQL';
            }
        
        }

    }
    closeConnections($con);


?> 
    <div class="container-fluid">
        <div class="row">
            <?php require_once("nav.php")?>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"><i class="fa fa-shop"></i> Edit Product</h1>
                </div>

                <form method="post">
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label for="txtProductName">Name <span class="text-danger">*</span></label>
                            <input type="text" name="txtProductName" class="form-control" id="txtProductName" required autofocus value="<?php echo $recPersons[0]['name']?>">
                        </div>
                        <div class="form-group col-12">
                            <label for="txtProductDesc">Description <span class="text-danger">*</span></label>
                            <input type="text" name="txtProductDesc" class="form-control" id="txtProductDesc" required value="<?php echo $recPersons[0]['description']?>">
                        </div>
                        <div class="form-group col-12">
                            <label for="txtProductPrice"> Price <span class="text-danger">*</span></label>
                            <input type="text" name="txtProductPrice" class="form-control" id="txtProductPrice" pattern="^\d*(\.\d{0,2})?$" required value="<?php echo $recPersons[0]['price']?>">
                        </div>
                        <div class="form-group col-12">
                            <label for="filePhoto1">Photo 1</label>
                            <input type="file" name="filePhoto1" class="form-control-file" id="filePhoto1" value="../img/<?php echo $recPersons[0]['description']?>">
                        </div>
                        <div class="form-group col-12">
                            <label for="filePhoto2">Photo 2</label>
                            <input type="file" name="filePhoto2" class="form-control-file" id="filePhoto2">
                        </div>
                    </div>

                    <button type="submit" name="btnUpdate" class="btn btn-success"><i class="fa fa-save"></i> Save Product</button>
                </form>
                
<?php require_once("footer.php")?>



