<?php
    require("../head.php");
    $adminLinkValue=1;
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
    
    $response = null;
    $filter = null;
    $notice = displayLostItemsAdmin($filter);
    lostExpired();

    if(isset($_POST["deleteLostAd"])){   
        $id = $_POST["idInput"];
        $response = deleteLostAdAdmin($id);
        $notice = displayLostItemsAdmin($filter);
    }

?>
<body>
    <div class="main-flex header">
        <div class="main-section">
            <?php require("../header_admin.php"); ?>
        </div>
    </div>
    
    <div class="main-flex page-body">
        <div class="aside"></div>
        <div class="main-section">

            <div class="flex-row"> 
                <h1 class="title">KAOTATUD ESEMED</h1>
            </div>
            
            <div class="clearfix-50"></div>
            <div class="filtersProductsLayout"> 
                <?php require("../admin_filter.php") ?>
                <div class="products">
                    <?php echo $notice?>
                </div>
            </div>
        </div> <!--main section -->
        <div class="aside"></div>
    </div><!-- main-flex-->
    
</body>