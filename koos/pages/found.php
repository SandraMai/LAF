<?php 
require('../head.php'); 
foundToExpired();
$offset = 0;
?>
<body>

<div class="main-flex header">
    <div class="aside"></div>

    <!-- HEADER -->
    <div class="main-section">
        <?php require('../header.php'); ?>
    </div>
    <div class="aside"></div>

</div>

<div class="main-flex page-body">
    <div class="aside"></div>


    <div class="main-section">

        <!-- HERO TEXT  -->
        <div class="flex-row"> 
            <h1 class="title">LEITUD ESEMED</h1>
        </div>

        <!-- PAGE NUMBERS -->
        <div class="flex-row"> 
            <div class="aside"></div>
            <div>1 2 3 </div>
        </div>

        <!-- PAGE BODY -->

        <div class="filtersProductsLayout"> 

            <?php require("../filter.php") ?>
            <div class="products">
                    <?php echo selectFoundPostsHTML($offset); ?>
            </div><!--.products -->

        </div><!--.filtersProductsLayout-->

        <div class="js-more-wrapper loadMoreButton"><button data-inf=0 data-type=2 class="js-load-more">lae juurde</button></div>

    </div><!--.main-section-->


    <div class="aside"></div>
</div><!--.main-flex-->




<script src="../js/found.js"></script>
<script src="../js/infiniteScroll.js"></script>
</body>
</html>