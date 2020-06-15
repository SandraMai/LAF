<?php
    require("../head.php");
    $response = null;
    $filter = null;
    $notice = displayLostItemsAdmin($filter);
    lostExpired();

    if(isset($_POST["delete"])){
        
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
                <?php require("../filter.php") ?>
                <div class="products">
                    <?php echo $notice?>
                </div>
            </div>
        </div> <!--main section -->
        <div class="aside"></div>
    </div><!-- main-flex-->
    
</body>