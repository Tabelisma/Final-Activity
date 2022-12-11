<?php
    session_start();
    $_SESSION['CURR_PAGE'] = 'products';

?>
<?php require_once("header.php")?>
<?php
    if(isset($_POST['btnAddProduct'])){
        $con = openConnection();
        $product_name = sanitizeInputs($con, $_POST['txtProductName']);
        $product_description = sanitizeInputs($con, $_POST['txtProductDesc']);
        $product_price = sanitizeInputs($con, $_POST['txtProductPrice']);
        $photo1 = "";
        $photo2 = "";
        $arrError = [];

        // File 
        $arrAllowFiles = ['jpeg', 'jpg', 'png'];
        $uploadDIR = '../img/';

        if(isset($_FILES['filePhoto1']) && isset($_FILES['filePhoto2'])){
            $fileName1 = $_FILES['filePhoto1']['name'];
            $fileSize1 = $_FILES['filePhoto1']['size'];
            $fileTemp1 = $_FILES['filePhoto1']['tmp_name'];
            $fileType1 = $_FILES['filePhoto1']['type'];

            $fileName2 = $_FILES['filePhoto2']['name'];
            $fileSize2 = $_FILES['filePhoto2']['size'];
            $fileTemp2 = $_FILES['filePhoto2']['tmp_name'];
            $fileType2 = $_FILES['filePhoto2']['type'];

            $fileExtTemp1 = explode('.', $fileName1); // thi become the array
            $fileExt1 = strtolower(end($fileExtTemp1)); 

            $fileExtTemp2 = explode('.', $fileName2); // this become the array
            $fileExt2 = strtolower(end($fileExtTemp2)); 

            if(in_array($fileExt1, $arrAllowFiles) == false)
                $arrError[] = "Photo 1: Extension File is not allowed, You can only choose a JPG or PNG file"; 

            if(in_array($fileExt2, $arrAllowFiles) == false)
                $arrError[] = "Photo 2: Extension File is not allowed, You can only choose a JPG or PNG file"; 

            if($fileSize1 > 5000000)
                $arrError[] = "Photo 1 should be 5MB Maximuim";
                
            if($fileSize2 > 5000000)
                $arrError[] = "Photo 2 size should be 5MB Maximuim";

            if(empty($arrError)){
                $photo1 = sanitizeInputs($con, $fileName1);;
                move_uploaded_file($fileTemp1, $uploadDIR . $fileName1);
                $photo2 = sanitizeInputs($con, $fileName2);
                move_uploaded_file($fileTemp2, $uploadDIR . $fileName2);
            }
            else{
                $arrError[] = "Something Wrong sending files";
            }
        }
        else{
            $arrError[] = "2 Photos File are Required";
        }


        if(empty($product_name))
            $arrError[] = "PRoduct Name is Required";
        
        if(empty($product_description))
            $arrError[] = "Product Description Name is Required";

        if(empty($product_price))
            $arrError[] = "Product Price is Required";            
        
        if(empty($arrError)){
            // Inserting Multiple Rows
            $strSQL = "
            
                INSERT INTO tbl_products 
                (name, description, price, photo1, photo2)
                VALUES 
                ('$product_name', '$product_description', $product_price, '$photo1', '$photo2')
            ";
            if(mysqli_query($con, $strSQL))
                header("location: product-added.php");
            else
                $arrError[] = 'Error: Failed SQL';
        
        }
        closeConnections($con);
    }
    // print_r($arrError);
?>
    <div class="container-fluid">
        <div class="row">
            <?php require_once("nav.php")?>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"><i class="fa fa-shop"></i> Add Products</h1>
                </div>

                <form method="post" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label for="txtProductName">Name <span class="text-danger">*</span></label>
                            <input type="text" name="txtProductName" class="form-control" id="txtProductName" required autofocus>
                        </div>
                        <div class="form-group col-12">
                            <label for="txtProductDesc">Description <span class="text-danger">*</span></label>
                            <input type="text" name="txtProductDesc" class="form-control" id="txtProductDesc" required>
                        </div>
                        <div class="form-group col-12">
                            <label for="txtProductPrice"> Price <span class="text-danger">*</span></label>
                            <input type="text" name="txtProductPrice" class="form-control" id="txtProductPrice" pattern="^\d*(\.\d{0,2})?$" required>
                        </div>
                        <div class="form-group col-12">
                            <label for="filePhoto1">Photo 1</label>
                            <input type="file" name="filePhoto1" class="form-control-file" id="filePhoto1">
                        </div>
                        <div class="form-group col-12">
                            <label for="filePhoto2">Photo 2</label>
                            <input type="file" name="filePhoto2" class="form-control-file" id="filePhoto2">
                        </div>
                    </div>

                    <button type="submit" name="btnAddProduct" class="btn btn-success"><i class="fa fa-plus"></i> Add Product</button>
                </form>
                <br><br>
                <h2><i class="fa fa-table"></i> List of Products</h2>
                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Product Description</th>
                                    <th>Price</th>
                                    <th>Photo 1</th>
                                    <th>Photo 2</th>
                                    <th colspan="2">Options</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $con = openConnection();
                                $strSQL = "SELECT * FROM tbl_products";
                                $recProducts = getRecord($con, $strSQL);
                                closeConnections($con);
                                if(!empty($recProducts)){

                                    foreach ($recProducts as $key => $value) {
                                        $con = openConnection();
                                        $strSQL = "SELECT * FROM tbl_products WHERE id = ".  $value['id'];
                                        $recProductsInfo = getRecord($con, $strSQL);
                                        echo '
                                        <tr>
                                            <td>' . $value['name'] . ' ' . '</td>
                                            <td>' . $value['description']  . '</td>
                                            <td>' .  $value['price'] . '</td>
                                            <td><img style="width: 2em" src="../img/' . $value['photo1'] . '"/></td>
                                            <td><img style="width: 2em" src="../img/' . $value['photo2'] . '"/></td>
                                            <td>
                                                <a href="update-product.php?k=' . $value['id'] . '" class="btn btn-success"><i class=" fa fa-edit"></i> Edit</a> 
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter"><i class=" fa fa-trash"></i> Remove</button>
                                                <!-- Modal -->
                                                <form>
                                                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLongTitle">Do you want remove this record?</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                            <div class="modal-body">
                                                                <p><b>Product Name: </b> ' .  $recProductsInfo[0]['name'] . ' </p>
                                                                <p><b>Product Description: </b>' . $recProductsInfo[0]['description'] .  '</p>
                                                                <p><b>Product Price: </b> ' .$recProductsInfo[0]['price'] . ' </p>
                                                            </div>
                                                                <div class="modal-footer">
                                                                    <a href="delete-product.php?k=' . $recProductsInfo[0]['id'] .'" class="btn btn-light" >Yes</a>
                                                                    <button type="button" class="btn btn-dark" data-dismiss="modal">No</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
        
                                        ';
                                        closeConnections($con);

                                    }
                                }
                            ?>
                               
                            </tbody>
                        </table>
                    </div>

            </main>
        </div>
    </div>
<?php require_once("footer.php")?>