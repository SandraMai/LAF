<?php 
    require('../head.php');

    if(isset($_SESSION["LAST_ACTIVITY"]) && (time() - $_SESSION["LAST_ACTIVITY"] > 1800)){
        session_unset(); 
        session_destroy();  
        header("Location: admin_login.php");
        exit();
    }
    
    if(!isset($_SESSION["userId"])){
        header("Location: admin_login.php");
        exit();
    }
    
    if(isset($_GET["logout"])){
      session_unset();
      session_destroy();
      header("Location: admin_login.php");
      exit();
    }
?>
<body>
    <div class="main-flex header">
        <div class="aside"></div>

        <!-- HEADER -->
        <div class="main-section">
            <?php require('../header_admin.php'); ?>
        </div>
        <div class="aside"></div>

    </div><!--.main-flex-->

    <div class="main-flex page-body">
        <div class="aside"></div>

            <div class="main-section">
                <!-- pealkiri  -->
                <div class="flex-row"> 
                    <h1 class="title">SEADED</h1>
                </div>

                <div class="flex-column"> 
                    <a class="admin-settings" href="admin_change_password.php">MUUDA PAROOLI</a>
                    <a class="admin-settings" href="admin_auction.php">OKSJONI SEADED</a>                    
                    <a class="admin-settings" href="admin_faq.php">KKK <br> LEHE MUUTMINE</a>
                    <a class="admin-settings" href="admin_storage.php">HOIUPAIGAD</a>     
                </div>
            </div>
        <div class="aside"></div>
    </div>

</body>
</html>