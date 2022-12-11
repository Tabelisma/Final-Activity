<?php
    session_start();
    require("functions.php");
    if(isset($_POST['btnLogin'])){
        $con = openConnection();

        $username = htmlspecialchars( $_POST['txtUsername']);
        $password = htmlspecialchars( $_POST['txtPassword']);

        $username = stripslashes($username);
        $password = stripslashes($password);

        $username = mysqli_real_escape_string($con, $username);
        $password = mysqli_real_escape_string($con, $password);
        
        $password = md5($password); // hash the password

        $strSQL = "
                    SELECT * FROM tbl_user 
                    WHERE username = '$username' 
                    AND password = '$password'     
        ";
        if($rsLogin = mysqli_query($con, $strSQL)){
            if(mysqli_num_rows($rsLogin) > 0){
                while($arrRec = mysqli_fetch_array($rsLogin)){
                    $_SESSION['username'] = $arrRec['username'];
                }
                if($_SESSION['username'] == "admin"){
                    header("location: admin-module/");
                }
                else{
                    header("location: customer-module/");
                }
            }
            else{
               echo 
               '
               <div class="alert alert-warning alert-dismissible fade show" role="alert">
               <strong>Error!</strong> Username / Password.
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
               </div>
               
               
               ';
            }
        }
        else
            echo 'ERROR: Could not execute your request';
        
            closeConnections($con);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/login.css">
    <title>Log In System</title>
</head>
<body>
        <div class="container" style="width: 25%;">
            <div class="row">
                <div class="col-12 mt-5 text-center">
                    <img src="blankDPinLogin.png" alt="Blank" class="profile-img-card rounded-circle w-25" >              
                    <p id="profile-name" class="profile-name-card"></p>
                    <form class="form-signin" method="post">
                        <div class="form-row align-items-center">
                            <div class="col-12 my-1 text-center">
                                <input type="text" name="txtUsername" id="txtUsername" class="form-control " placeholder="User Name" required autofocus>
                                <input type="password" name="txtPassword"  id="txtPassword" class="form-control " placeholder="Password" required>
                                <button class="btn btn-lg btn-info btn-block btn-signin form-control" type="submit" name="btnLogin">Log in</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    <script src="js/jquery.js"></script>    
    <script src="js/bootstrap.js"></script>
</body>
</html>