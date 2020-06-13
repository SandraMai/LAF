<?php
    require("../head.php");

    $filter = null;
    $notice = displayLostItems($filter);

/*  // Praegu ei toota sest pole andmebaasi
    if (isset($_POST["tehnika"])){
        $filter = 'tehnika';
        $notice = displayLostItems($filter);
    }elseif (isset($_POST["muu"])){
        $filter = 'muu';
        $notice = displayLostItems($filter);
    }elseif (isset($_POST["riided"])){
        $filter = 'riided';
        $notice = displayLostItems($filter);
    }else{
        $notice = displayLostItems($filter);
    }
    */
?>

<body>
    <div class="main-flex header">
        <div class="main-section">
            <?php require("../header.php"); ?>
        </div>
    </div>
    
    <div class="main-flex page-body">
    <div class="aside"></div>
        <div class="main-section">

            <div class="flex-row"> 
                <h1 class="title">KAOTATUD ESEMED</h1>
            </div>

            <div class="flex-row"> 
                <a class="add-ad" href="new_lost.php">LISA ESE</a>
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