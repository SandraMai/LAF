<?php require('../head.php'); 
require("../functions/oksjon_functions.php");
require("../../../../config_laf.php");
/*require("functions_user.php");
require("functions_main.php");
require("functions_pic.php");*/
$database = "if19_herman_pe_1";

$typeOfFilter=null;
$notice=readAuctionPics($typeOfFilter);
$amount=countFilters($typeOfFilter);
if(isset($_POST["riided"])){
    $typeOfFilter='Riided';
    $notice = readAuctionPics($typeOfFilter);
    $amount =countFilters($typeOfFilter);

}
if(isset($_POST["tehnika"])){
    $typeOfFilter='Tehnika';
    $notice = readAuctionPics($typeOfFilter);
    $amount =countFilters($typeOfFilter);

}
if(isset($_POST["muu"])){
    $typeOfFilter='Muu';
    $notice = readAuctionPics($typeOfFilter);
    $amount =countFilters($typeOfFilter);    
}
if(isset($_POST["koik"])){
    $typeOfFilter=null;
    $notice = readAuctionPics($typeOfFilter);
    $amount =countFilters($typeOfFilter);
}



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
<div class="main-flex">
    <div class="aside"></div>
    <div class="main-section">
        <!-- HERO TEXT  -->
        <div class="flex-row"> 
            <h1 class="title">OKSJON</h1>
        </div>
        <!-- HERO BUTTON  -->
        <div class="flex-row"> 
        </div>
        <!-- PAGE NUMBERS -->
        <div class="flex-row"> 
            <div class="aside"></div>
            <div>                
                <?php
                echo "Tänane kuupäev " . date("Y/m/d") . "<br>";
                ?></div>
        </div>
        <!-- PAGE BODY -->
        <div class="flex-row"> 
            <div class="filters">
                <h2 class="flex-column">FILTERS</h2>
                <ul class="ul flex-column">
                <form method="POST" action="#">
                    <li><input id="clothes" name="riided" type="submit" value="RIIDED"></li>
                    <li><input id="technic" name="tehnika" type="submit" value="TEHNIKA"></li>
                    <li><input id="other" name="muu" type="submit" value="MUU"></li>
                    <li><input id="all" name="koik" type="submit" value="KÕIK" ></li>
                    <?php echo $amount; ?>
                </form>
                </ul>
            </div>
            <div id="products">
                <div id="elements">
                   <?php
                    echo $notice;
                    ?>
                </div>
            </div><!--.products -->
        </div><!--.flex-row-->
    </div>
    <div class="aside"></div>
</div>
<script src="../js/timer.js"></script>
<script src="../js/script.js"></script>
</body>
</html>