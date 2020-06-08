<?php
$database = "if19_LAF";


$typeOfFilter=null;

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
<html>
<body>
<div class="flex-row"> 
            <div class="filters">
                <h2 class="flex-column">FILTERS</h2>
                <ul class="ul flex-column">
                <form method="POST" action="#">
                    <li><input id="clothes" name="riided" type="submit" value="RIIDED"></li>
                    <li><input id="technic" name="tehnika" type="submit" value="TEHNIKA"></li>
                    <li><input id="other" name="muu" type="submit" value="MUU"></li>
                    <li><input id="all" name="koik" type="submit" value="KÕIK" ></li>
                </form>
                </ul>
            </div>
            <div id="products">
                <div id="elements">
                </div>
            </div><!--.products -->
        </div><!--.flex-row-->
<script src="../js/timer.js"></script>
<script src="../js/script.js"></script>
</body>
</html>