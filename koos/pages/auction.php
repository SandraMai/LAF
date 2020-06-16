<?php 

require('../head.php'); 

$database = "if19_LAF";
$show=null;
$searchedName=null;
$searchedCategory=null;
$searchedArea=null;
$linkValue=3;

auctionFiltration();

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
            <?php require("../filter.php") ?>
            <div class="products">
                <?php echo getAuctionElements($show,$searchedName,$searchedCategory,$searchedArea,$linkValue); ?>
            </div><!--.flex-row-->
        </div><!--.products -->
            
    </div>
    <div class="aside"></div>
</div>
<script src="../js/timer.js"></script>
<script src="../js/script.js"></script>
</body>
</html>