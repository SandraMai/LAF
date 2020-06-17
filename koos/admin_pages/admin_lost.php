<?php
    require("../head.php");

    $adminLinkValue=1;
    $offset=0;
    $searchedArea=null;
    $searchedCategory=null;
    $searchedName=null;
    $sentElement=null;
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
    
    $response = null;
    $filter = null;

    lostExpired();

    if(isset($_POST["deleteLostAd"])){   
        $id = $_POST["idInput"];
        $response = deleteLostAdAdmin($id);
        $notice = displayLostItemsAdmin($offset,$searchedName,$sentElement,$searchedArea,$adminLinkValue);
    }

?>
<body>
    
<?php require("../header_admin.php"); ?>

    
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
                    <?php echo displayLostItemsAdmin($offset,$searchedName,$sentElement,$searchedArea,$adminLinkValue);?>
                </div>
                </div><!--.filtersProductsLayout-->

<div class="js-more-wrapper loadMoreButton"><button data-inf=0 data-type=1 class="js-load-more">lae juurde</button></div>
        </div> <!--main section -->
        <div class="aside"></div>
    </div><!-- main-flex-->

    
</body>