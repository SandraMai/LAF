<?php 
require('../head.php'); 
foundToExpired();


if(isset($_POST["deleteAd"])){
    $id = $_POST["idInput"];
    deleteFoundAdmin($id);
}
?>
<body>

<div class="main-flex header">
    <div class="aside"></div>

    <!-- HEADER -->
    <div class="main-section">
        <?php require('../header_admin.php'); ?>
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

        <div class="flex-row"> 
            <a class="add-ad" href="new_found.php">LISA ESE</a>
        </div>
        <div class="clearfix-50">
        </div>
        <!-- PAGE BODY -->

        <div class="filtersProductsLayout"> 

            <?php require("../filter.php") ?>
            <div class="products">
                    <?php echo selectFoundPostsAdmin(); ?>
            
            </div><!--.products -->
        </div><!--.flex-row-->

    </div><!--.main-section-->


    <div class="aside"></div>
</div>




<script src="../js/found.js"></script>
</body>
</html>