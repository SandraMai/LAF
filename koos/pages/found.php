<?php require('../head.php'); ?>
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
        <div class="flex-row"> 

            

        </div><!--.flex-row-->
        <div class="flex-row"> 
            <?php require("../filter.php") ?>
            <div id="products">
                <div id="elements">
                    <p>Hetkel asju pole</p>
                </div>
            </div><!--.flex-row-->
            </div><!--.products -->
    </div>
    <div class="aside"></div>
</div>




<script src="../js/found.js"></script>
</body>
</html>