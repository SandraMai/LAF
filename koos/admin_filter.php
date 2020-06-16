<?php
    $database = "if19_LAF";
    $storageHTML = readStoragesForSelect();

    $show=null;
    $searchedName=null;
    $searchedCategory=null;
    $searchedStorage = null;
    //$searchedArea=null;
    $offset = 0;

    if(isset($_POST["submitSearch"])){
        $searchedName = $_POST["otsingSona"];
        $searchedCategory = $_POST["category"];
        $searchedStorage = $_POST["storagePlace"];
        
        //$searchedArea =($_POST["area"]);
        $thisLink =($_POST["linkname"]);
        if($linkValue=1){
            $notice = displayLostItemsFiltrationAdmin($offset,$searchedName,$searchedCategory,$thisLink);
        }else if($linkValue=2){
            $searchedStorage = ($_POST["storagePlace"]);
            getAuctionElements($show,$searchedName,$searchedCategory,$searchedStorage,$thisLink);
            $notice = "otsing YEET";
        }else if($linkValue=3){
            $searchedStorage = ($_POST["storagePlace"]);
            getAuctionElements($show,$searchedName,$searchedCategory,$searchedStorage,$thisLink);
            $notice = "otsing YEET";
        }

    }
?>


            <div class="filters">
                <h2 class="flex-column" onClick="window.location.reload();" id="filterMain">FILTREERI</h2>
                <ul class="ul flex-column">
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="filterForm">

                    <li><input id="other" name="otsingSona" type="input" placeholder="Otsingusõna" value="<?php echo $searchedName;?>"></li>

                    <li>
                        <select name="storagePlace" id="storagePlace">
                            <option disabled selected value>Hoiupaik</option>
                            <?php $arrayStorage = $storageHTML;
                            var_dump($arrayStorage);
                        for ($i=0; $i < sizeof($arrayStorage); $i++) :
                            $selected = "";
                            if($arrayStorage[$i] == $searchedCategory) {
                                $selected = "selected";
                            }
                                ?><option value="<?php echo $arrayStorage[$i];?>" <?php echo $selected; ?>><?php echo $arrayStorage[$i]; ?></option><?php

                        endfor; ?>
                            
                        </select>

                        <!-- <input id="other" name="area" type="input" placeholder="Asukoht" value="<?php //echo $searchedArea;?>"></li> -->

                    <li>
                        <select name="category" id="category" value="<?php echo $searchedCategory;?>">
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