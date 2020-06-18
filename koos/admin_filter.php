<?php
    $database = "if19_LAF";
    $auctionListing=null;
    $show=null;
    $searchedName=null;
    $searchedCategory=null;
    $searchedStorage = null;
    $searchedArea=null;
    $offset = 0;
    $searchedStorageID=null;
    $searchedEndDate=null;
    $searchedStartDate=null;


    if(isset($_POST["submitSearch"])){
        $searchedStorage=cleanTextInput('storagePlace');
        $searchedStorageID=storageToID($searchedStorage);
        $searchedName =cleanTextInput("otsingSona");
        if(isset($_POST["category"])){
            $searchedCategory =cleanTextInput('category');
            
            if($searchedCategory=="riided"){
                $sentElement=1;
            }elseif($searchedCategory=="tehnika"){
                $sentElement=2;
            }elseif($searchedCategory=="muu"){
                $sentElement=3;
            }
        }else{$searchedCategory =null;
            $sentElement=null;
        }
        if(isset($_POST["Date-Start"])){
            $searchedStartDate=$_POST["Date-Start"];
            }
         if(isset($_POST["Date-Start"])){
            $searchedEndDate=$_POST["Date-End"];
           }
        if ($adminLinkValue!=4):
            $searchedArea =($_POST["area"]);
        endif;
        $thisLink =($_POST["linkname"]);
        if($thisLink==1){
            $notice = displayLostItemsAdmin($offset,$searchedName,$sentElement,$searchedArea,$thisLink,$searchedStartDate,$searchedEndDate);
        }else if($thisLink==2) {
            $notice = selectFoundPostsAdmin($offset,$searchedName,$sentElement, $searchedStorageID,$searchedArea,$thisLink,$searchedStartDate,$searchedEndDate);
        }else if($thisLink==3){
            $notice=getSuccessfulAuctions($searchedName,$sentElement,$searchedArea,$searchedStorageID,$thisLink, $offset,$searchedStartDate,$searchedEndDate);   
        }else if($thisLink==4){
            $searchedArea=null;
            $notice=getExpiredAuctions($searchedName,$sentElement, $searchedStorageID,$thisLink, $offset,$searchedStartDate,$searchedEndDate);   
        }
    
    
    }
?>


            <div class="filters">
                <h2 class="flex-column" onClick="window.location.reload();" id="filterMain">FILTREERI</h2>
                <ul class="ul flex-column">
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="filterForm">

                    <li><input id="other" name="otsingSona" type="input" placeholder="Otsingusõna" value="<?php echo $searchedName;?>" data-value="<?php echo $searchedName;?>"></li>

                    <li>
                        <?php if ($adminLinkValue!=1):?>
                        <select name="storagePlace" id="storagePlace" value="<?php echo $searchedStorage;?>" data-value="<?php echo $searchedStorage;?>">
                            <option disabled selected value>Hoiupaik</option>
                            <?php $arrayStorage = counterOfStorages();
                        for ($i=0; $i < sizeof($arrayStorage); $i++) :
                            $selected = "";
                            if($arrayStorage[$i] == $searchedStorage) {
                                $selected = "selected";
                            }
                                ?><option value="<?php echo $arrayStorage[$i];?>" <?php echo $selected; ?>><?php echo $arrayStorage[$i]; ?></option><?php

                        endfor; ?>
                            
                        </select>
                    <?php endif;?>
                        <!-- <input id="other" name="area" type="input" placeholder="Asukoht" value="<?php //echo $searchedArea;?>"></li> -->

                    <li>
                        <select name="category" id="category" value="<?php echo $searchedCategory;?>" data-value="<?php echo $searchedCategory;?>">
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

                    <li><?php if ($adminLinkValue==4):?><input id="other" hidden name="area" type="input" placeholder="Asukoht" value="<?php echo $searchedArea;?>" data-value="<?php echo $searchedArea;?>"><?php endif;?></li>
                        <?php if ($adminLinkValue==3):?>
                        <li><input id="other" name="area" hidden type="input"  placeholder="Leidmise koht" value="<?php echo $searchedArea;?>" data-value="<?php echo $searchedArea;?>"></li>
                    <?php  endif;?>
                    <?php if ($adminLinkValue==2):?>
                        <li><input id="other" name="area" type="input" placeholder="Leidmise koht" value="<?php echo $searchedArea;?>" data-value="<?php echo $searchedArea;?>"></li>
                    <?php  endif;?>
                    <?php if ($adminLinkValue==1):?>
                        <li><input id="other" name="area" type="input" placeholder="Kaotamise koht" value="<?php echo $searchedArea;?>" data-value="<?php echo $searchedArea;?>"></li>
                    <?php  endif;?>
                    <li class="flex-column"><label>Alguskuupäev</label></li>
                    <li><input id="start-date" name="Date-Start" type="date" value="<?php echo $searchedStartDate?>" data-value="<?php echo $searchedStartDate;?>"></li>
                    <li class="flex-column"><label>Lõppkuupäev</label></li>
                    <li><input id="end-date" name="Date-End" type="date" value="<?php echo $searchedEndDate?>" data-value="<?php echo $searchedEndDate;?>"></li>
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
