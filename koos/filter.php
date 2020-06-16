<?php
$database = "if19_LAF";

$show=null;
$searchedName=null;
$searchedCategory=null;
$searchedArea=null;
$offset = 0;
$filter = null;
if(isset($_POST["submitSearch"])){
    $searchedName = ($_POST["otsingSona"]);
    $searchedCategory =($_POST["category"]);
    $searchedArea =($_POST["area"]);
    $thisLink =($_POST["linkname"]);
    if($linkValue=1){
        $notice = displayLostItems($filter, $offset,$searchedName,$searchedCategory,$searchedArea,$thisLink);
    }else if($linkValue=2){
        getAuctionElements($show,$searchedName,$searchedCategory,$searchedArea,$thisLink);
         $notice = "otsing YEET";
    }else if($linkValue=3){
        getAuctionElements($show,$searchedName,$searchedCategory,$searchedArea,$thisLink);
         $notice = "otsing YEET";
    }

}
?>


            <div class="filters">
                <h2 class="flex-column" onClick="window.location.reload();" id="filterMain" >FILTREERI</h2>
                <ul class="ul flex-column">
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="filterForm">
                    <li><input id="other" name="otsingSona" type="input" placeholder="Otsingu sõna" value="<?php
                    echo $searchedName;?>"></li>
                    <li>
                        <select name="category" id="category" value="<?php echo $searchedCategory;?>">
                            <option value="riided">Riided</option>
                            <option value="tehnika">Tehnika</option>
                            <option value="muu">Muu</option>
                        </select>
                    </li>
                    <li><input id="other" name="area" type="input" placeholder="Asukoht" value="<?php echo $searchedArea;?>"></li>
                    <li><input id="start-date" name="Date-Start" type="date"></li>
                    <li><input id="end-date" name="Date-End" type="date"></li>
                    <li><input type="hidden" name="linkname" value="<?php echo $linkValue?>"></li>
                    <input name="submitSearch" id="submitSearch" type="submit" value="Otsi">
                        <span id="notice">
                            <?php  ?>
                        </span>
                    </li>
                </form>
                </ul>
            </div>
<script src="../js/timer.js"></script>
<script src="../js/script.js"></script>