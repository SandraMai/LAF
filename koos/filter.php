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

<div class="flex-row"> 
            <div class="filters">
                <h2 class="flex-column">FILTERS</h2>
                <ul class="ul flex-column">
                <form method="POST" action="#">
                    <li><input id="other" name="muu" type="input" placeholder="Otsingu sõna"></li>
                    <li>
                        <select name="category" id="category">
                            <option value="riided">Riided</option>
                            <option value="tehnika">Tehnika</option>
                            <option value="muu">Muu</option>
                        </select>
                    </li>
                    <li><input id="other" name="muu" type="input" placeholder="Asukoht"></li>
                    <li><input id="start-date" name="Date-Start" type="date"></li>
                    <li><input id="end-date" name="Date-End" type="date"></li>
                    <li>
                        <input name="submitSearch" id="submitSearch" type="submit" value="Otsi">
                        <span id="notice">
                            <?php  ?>
                        </span>
                    </li>
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
