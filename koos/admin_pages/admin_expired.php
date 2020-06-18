<?php 

    $pageTitle="LAF admin. Aegunud kuulutused";
    require('../head.php'); 

    $adminLinkValue=4;
    $sentElement=null;
    $searchedEndDate=null;
    $searchedStartDate=null;
    $offset=null;
    $searchedStorageID=null;

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

    if(isset($_POST["deleteAd"])){
        $id = $_POST["idInput"];
        deleteFoundAdmin($id);
        $notice = getExpiredAuctions($searchedName,$sentElement, $searchedStorageID,$adminLinkValue, $offset,$searchedStartDate,$searchedEndDate);
    }
?>

<body>


<?php require('../header_admin.php'); ?>


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
                    <?php echo getExpiredAuctions($searchedName,$sentElement, $searchedStorageID,$adminLinkValue, $offset,$searchedStartDate,$searchedEndDate); ?>
            
            </div><!--.products -->
        </div><!--.flex-row-->
    </div><!--.main-section-->


    <div class="aside"></div>
</div>

</body>
</html>