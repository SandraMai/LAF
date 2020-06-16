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
    
    $searchedArea =($_POST["area"]);
    $thisLink =($_POST["linkname"]);
    if(isset($_POST["category"])){
        $searchedCategory =($_POST["category"]);
        if($searchedCategory=="riided"){
            $searchedCategory=1;
        }elseif($searchedCategory=="tehnika"){
            $searchedCategory=2;
        }elseif($searchedCategory=="muu"){
            $searchedCategory=3;
        }
    }else{$searchedCategory =null;
    }
    if($linkValue=1){
        $notice = displayLostItems($offset,$searchedName,$searchedCategory,$searchedArea,$thisLink);
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
                        <select name="category" id="category"  value="<?php echo $searchedCategory;?>">
                        <option disabled selected value>  Vali kategooria  </option>
                        <?php 
                            $array = array("riided", "tehnika", "muu");
                        for ($i=0; $i < sizeof($array); $i++) :
                            $selected = "";
                            if($array[$i] == $searchedCategory) {
                                $selected = "selected";
                            }
                                ?><option value="<?php echo $array[$i];?>" <?php echo $selected; ?>><?php echo $array[$i]; ?></option><?php

                        endfor; ?>
                            
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