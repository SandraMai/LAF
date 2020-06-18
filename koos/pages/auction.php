<?php 

$pageTitle="Oksjon";

require('../head.php'); 

$database = "if19_LAF";
$offset = 0;
$show=null;
$searchedName=null;
$searchedCategory=null;
$searchedArea=null;
$linkValue=3;
$searchedEndDate=null;
$searchedStartDate=null;

auctionFiltration();

$notice = getAuctionElements($show,$searchedName,$searchedCategory,$searchedArea, $linkValue, $offset,$searchedStartDate,$searchedEndDate);
?>
<body>
    

        <?php require('../header.php'); ?>

<div class="main-flex page-body">
    <div class="aside"></div>
    <div class="main-section">
        <!-- HERO TEXT  -->
        <div class="flex-row"> 
            <h1 class="title">OKSJON</h1>
        </div>
        <div class="clearfix-50"></div>
        <!-- PAGE BODY -->
        <div class="filtersProductsLayout"> 
            <?php 
                require("../filter.php"); 
            ?>
            <div class="products">
                <?php 
                
                if ($notice==100) {
                    $notice = '<p class="flex-row">Hetkel esemeid pole!</p>';
                }

                echo $notice;
                
                ;?>
            </div><!--.products -->

        </div><!--.filtersProductsLayout-->


    </div><!--.main-section-->


    <div class="aside"></div>
</div><!--.main-flex-->


<script src="../js/timer.js"></script>
<script src="../js/infiniteScroll.js"></script>
</body>
</html>