<?php 
require("../../../../config_laf.php");
require('../functions/functions.php');
require('../functions/database_functions.php');
require('../functions/admin_oksjon_functions.php');
require('../functions/oksjon_functions.php');
require('../functions/admin_functions.php');
require('../functions/admin_filtration.php');
$database = "if19_LAF";


    $offset = $_POST['inf'];
    $searchedName = $_POST['name'];
    $searchedCategory = $_POST['cat'];
    $searchedArea = $_POST['area'];
    $atype = $_POST['atype'];
    $datestart = $_POST['datestart'];
    $dateend = $_POST['dateend'];
    $getMore = null;
    $searchedStorage = $_POST['storage'];
    $searchedStorageID=storageToID($searchedStorage);

    if($searchedCategory=="riided"){
        $sentElement=1;
    }elseif($searchedCategory=="tehnika"){
        $sentElement=2;
    }elseif($searchedCategory=="muu"){
        $sentElement=3;
    } else{
        $sentElement=null;
    }

    // Is admin page
    if ( $atype == 1 ) {
        if ($_POST['type'] == 1) {
            $getMore = displayLostItemsAdmin($offset,$searchedName,$sentElement,$searchedArea,2);

        } elseif ($_POST['type'] == 2) {
           $getMore = selectFoundPostsAdmin($offset,$searchedName,$sentElement, $searchedStorageID,$searchedArea,null);

        } elseif ($_POST['type'] == 3) {
           // $getMore = getAuctionElements(null, $searchedName, $sentElement, $searchedArea, 3, $offset );
        }
    } elseif ($atype == 0) {
        if ($_POST['type'] == 1) {
            $getMore = displayLostItems($offset, $searchedName, $searchedCategory, $searchedArea, 1, $datestart, $dateend);

        } elseif ($_POST['type'] == 2) {
            $getMore = selectFoundPostsHTML($offset, $searchedName, $searchedCategory, $searchedArea, 2, $datestart, $dateend);

        } elseif ($_POST['type'] == 3) {
            $getMore = getAuctionElements(null, $searchedName, $sentElement, $searchedArea, 3, $offset, $datestart, $dateend );
        }
    }



    if ($getMore == 100) {
        echo $getMore;
    } else {
        echo json_encode( $getMore, JSON_PRETTY_PRINT );
    }

       
        




