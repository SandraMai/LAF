<?php 
require('../head.php'); 
foundToExpired();
$offset = 0;
$thisLink=2;

$searchedName=null;
$searchedCategory=null;
$searchedArea=null;
$thisLink=null;

$notice = selectFoundPostsHTML($offset,$searchedName,$sentCategory,$searchedArea,$thisLink);



?>
<body>


<?php require('../header.php'); ?>


<div class="main-flex page-body">
    <div class="aside"></div>


    <div class="main-section">

        <!-- HERO TEXT  -->
        <div class="flex-row"> 
            <h1 class="title">LEITUD ESEMED</h1>
        </div>

        <!-- PAGE BODY -->
        <div class="clearfix-50"></div>
        <div class="filtersProductsLayout"> 

            <?php require("../filter.php") ?>
            <div class="products">
                    <?php
                        if ($notice==100) {
                            $notice = '<p class="flex-row">Hetkel esemeid pole!</p>';
                        }
                    
                     echo $notice; ?>
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