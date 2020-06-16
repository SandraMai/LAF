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
                            <?php echo $storageHTML; ?>
                        </select>

                        <!-- <input id="other" name="area" type="input" placeholder="Asukoht" value="<?php //echo $searchedArea;?>"></li> -->

                    <li>
                        <select name="category" id="category" value="<?php echo $searchedCategory;?>">
                            <option disabled selected value>Kategooria</option>
                            <option value="1">Riided</option>
                            <option value="2">Tehnika</option>
                            <option value="3">Muu</option>
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