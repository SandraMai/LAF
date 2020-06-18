<?php
    $pageTitle="Hoiupaigad";
    require('../head.php');
    $storagePlacesHTML = readStoragePlaces();
?>
<body>

    <?php require('../header.php'); ?>


    <div class="main-flex page-body">
    <div class="aside"></div>

        <div class="main-section">
            <!-- pealkiri  -->
            <div class="flex-row"> 
                <h1 class="title">HOIUPAIGAD</h1>
            </div>

            <div class="storageLayout">
                <div class="storageBox">
                    <?php
                        echo $storagePlacesHTML;
                    ?>

                </div><!--.storage-places.flex-column-->

                <div class="storageImageBox">
                    <img class="img-full storageImage" src="../images/linnakukaart.jpg">
                </div><!--.storage-pic-->
            </div><!--.storageLayout-->


        </div>

    <div class="aside"></div>
    </div>
</body>