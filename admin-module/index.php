<?php
    session_start();
    $_SESSION['CURR_PAGE'] = 'dashboard';
    if(!isset($_SESSION['username'])) {
        header("Location: login.php");
    }
?>
<?php require_once("header.php")?>
    <div class="container-fluid">
        <div class="row">
            <?php require_once("nav.php")?>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"><i class="fa fa-dashboard"></i> Dashboard</h1>
                </div>
                <div class="card">
                <h5 class="card-header">Total Products Sold: </h5>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo isset($_SESSION['totalsold'])? number_format($_SESSION['totalsold']): '0' ?></h5>
                    </div>
                </div>
            </main>
        </div>
    </div>
<?php require_once("footer.php")?>

