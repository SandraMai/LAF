<?php 
require("../../../../config_laf.php");
require('../functions/functions.php');
require('../functions/database_functions.php');
$database = "if19_LAF";



if( isset($_POST['inf'])) {

    $offset = $_POST['inf'];
    $filter = null;

    if ($_POST['inf'] == 1) {

    }

       
        
        $getMore = displayLostItems($filter, $offset);

        if ($getMore == 100) {
            echo $getMore;
        } else {
            echo json_encode( $getMore, JSON_PRETTY_PRINT );
        }




}


?>

