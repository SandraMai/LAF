<?php 
    require("index.php");
    $clothesCount = 0;
    $technologyCount = 0;
    $othersCount = 0;

    function counter($filter){

        if (isset($_POST["tehnika"])){
            $technologyCount++;
            echo $technologyCount;
        }
    }
?>