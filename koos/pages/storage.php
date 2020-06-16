<?php
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

            <div class="storage-places flex-column">
                <ul>
                <?php
                    echo $storagePlacesHTML;
                ?>
                </ul>

            </div>

            <div class="storage-pic">
                <img class="img-full" src="../linnakukaart.jpg">
            </div>
        </div>

    <div class="aside"></div>
    </div>
</body>