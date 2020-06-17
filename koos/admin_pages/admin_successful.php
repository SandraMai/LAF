<?php 
    require('../head.php'); 

    
    $adminLinkValue=3;
    $offset = 0;
    $show=null;
    $searchedName=null;
    $searchedCategory=null;
    $searchedArea=null;
    $sentElement=null;
    $searchedEndDate=null;
    $searchedStartDate=null;
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


<?php require('../header_admin.php'); ?>


<div class="main-flex page-body">
    <div class="aside"></div>


    <div class="main-section">

        <!-- HERO TEXT  -->
        <div class="flex-row"> 
            <h1 class="title">EDUKAD OKSJONID</h1>
        </div>

        <div class="clearfix-50">
        </div>
        <!-- PAGE BODY -->

        <div class="filtersProductsLayout"> 

            <?php require("../admin_filter.php") ?>
            <div class="products">
                    <?php echo getSuccessfulAuctions($searchedName,$sentElement,$searchedArea,$searchedStorageID, $adminLinkValue, $offset,$searchedStartDate,$searchedEndDate); ?>
            
            </div><!--.products -->
            </div><!--.filtersProductsLayout-->

<div class="js-more-wrapper loadMoreButton"><button data-inf=0 data-type=3 class="js-load-more">lae juurde</button></div>

    </div><!--.main-section-->


    <div class="aside"></div>
</div>

</body>
</html>