<?php
    require("../head.php");
    $linkValue=1;
    $searchedName=null;
    $searchedCategory=null;
    $searchedArea=null;
    $thisLink=null;
    $offset = 0;
    $filter = null;
    $notice = displayLostItems($filter, $offset,$searchedName,$searchedCategory,$searchedArea,$thisLink);
    if ($notice == 100) {
        $notice = '<p class="flex-row">Hetkel esemeid pole!</p>';
    }
    lostExpired();

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
                    
                </div><!--.products-->
                
            </div><!--.filtersProductsLayout-->

            <div class="js-more-wrapper loadMoreButton"><button data-inf=0 data-type=1 class="js-load-more">lae juurde</button></div>
        </div> <!--main section -->
        <div class="aside"></div>
    </div><!-- main-flex-->
    


<script src="../js/infiniteScroll.js"></script>
</body>