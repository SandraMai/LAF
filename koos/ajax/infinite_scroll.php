<?php 
require("../../../../config_laf.php");
require('../functions/functions.php');
require('../functions/database_functions.php');
$database = "if19_LAF";



if( isset($_POST['inf'])) {

    $offset = $_POST['inf'];
    $filter = null;

    if ($_POST['type'] == 1) {

        $getMore = displayLostItems($filter, $offset,$filter, $offset,$searchedName,$searchedCategory,$searchedArea,$thisLink);

        if ($getMore == 100) {
            echo $getMore;
        } else {
            echo json_encode( $getMore, JSON_PRETTY_PRINT );
        }

    } elseif ($_POST['type'] == 2) {

        $getMore = selectFoundPostsHTML($offset);

        if ($getMore == 100) {
            echo $getMore;
        } else {
            echo json_encode( $getMore, JSON_PRETTY_PRINT );
        }
    }

       
        



}


?>

