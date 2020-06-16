<?php 
    require('../head.php'); 

    $notice = getExpiredAuctions();
    $adminLinkValue=4;
    if(isset($_SESSION["LAST_ACTIVITY"]) && (time() - $_SESSION["LAST_ACTIVITY"] > 10)){
        session_unset(); 
        session_destroy();  
        header("Location: admin_login.php");
        exit();
    }
    
    if(isset($_SESSION["user_IP"]) != $_SERVER["REMOTE_ADDR"]){
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

    if(isset($_POST["deleteAd"])){
        $id = $_POST["idInput"];
        deleteFoundAdmin($id);
        $notice = getExpiredAuctions();
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

</div>

<div class="main-flex page-body">
    <div class="aside"></div>


    <div class="main-section">

        <!-- HERO TEXT  -->
        <div class="flex-row"> 
            <h1 class="title">AEGUNUD KUULUTUSED</h1>
        </div>

        <div class="clearfix-50">
        </div>
        <!-- PAGE BODY -->

        <div class="filtersProductsLayout"> 

            <?php require("../admin_filter.php") ?>
            <div class="products">
                    <?php echo $notice ?>
            
            </div><!--.products -->
        </div><!--.flex-row-->

    </div><!--.main-section-->


    <div class="aside"></div>
</div>

</body>
</html>