<?php 
require("../../../../config_laf.php");
require('../functions/functions.php');
require('../functions/database_functions.php');
require('../functions/admin_oksjon_functions.php');
require('../functions/oksjon_functions.php');
$database = "if19_LAF";


    $offset = $_POST['inf'];
    $searchedName = $_POST['name'];
    $searchedCategory = $_POST['cat'];
    $searchedArea = $_POST['area'];

    if($searchedCategory=="riided"){
        $sentElement=1;
    }elseif($searchedCategory=="tehnika"){
        $sentElement=2;
    }elseif($searchedCategory=="muu"){
        $sentElement=3;
    } else{
        $sentElement=null;
    }

    if ($_POST['type'] == 1) {

        $getMore = displayLostItems($offset, $searchedName, $searchedCategory, $searchedArea, 1);

        if ($getMore == 100) {
            echo $getMore;
        } else {
            echo json_encode( $getMore, JSON_PRETTY_PRINT );
        }

    } elseif ($_POST['type'] == 2) {

        $getMore = selectFoundPostsHTML($offset, $searchedName, $searchedCategory, $searchedArea, 2);

        if ($getMore == 100) {
            echo $getMore;
        } else {
            echo json_encode( $getMore, JSON_PRETTY_PRINT );
        }
    } elseif ($_POST['type'] == 3) {
        $getMore = getAuctionElements(null, $searchedName, $sentElement, $searchedArea, 3, $offset );

        if ($getMore == 100) {
            echo $getMore;
        } else {
            echo json_encode( $getMore, JSON_PRETTY_PRINT );
        }
    }

       
        







