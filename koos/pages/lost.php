<?php
    require("../head.php");


    // Viidatud headis
    //require("../../../config_laf20.php");
    //require("functions_database.php");
    //$database = 'if19_anete_va_1';
    $filter = null;
    $notice = null;
    $url = "new_lost.php";

/*  // Praegu ei toota sest pole andmebaasi
    if (isset($_POST["tehnika"])){
        $filter = 'tehnika';
        $notice = displayLostItems($filter);
        $counter = file_get_contents("../txt/technoCounter.txt");
        file_put_contents("../txt/technoCounter.txt", $counter+1);
    }elseif (isset($_POST["muu"])){
        $filter = 'muu';
        $notice = displayLostItems($filter);
        $counter = file_get_contents("../txt/otherCounter.txt");
        file_put_contents("../txt/otherCounter.txt", $counter+1);
    }elseif (isset($_POST["riided"])){
        $filter = 'riided';
        $notice = displayLostItems($filter);
        $counter = file_get_contents("../txt/clothesCounter.txt");
        file_put_contents("../txt/clothesCounter.txt", $counter+1);
    }else{
        $notice = displayLostItems($filter);
    }
    */
?>

<body>
    <div class="main-flex header">
        <div class="main-section">
            <?php require("../header.php"); ?>
        </div>
    </div>

    <div class="main-flex">
        <div class="main-section">

            <div class="flex-row"> 
                <h1 class="title">KAOTATUD ESEMED</h1>
            </div>

            <div class="flex-row"> 
                <button class="add-ad"><a href="<?php echo $url ?>">Lisa kuulutus</a></button>
            </div>

        
            <div class="flex-row"> 

                <div class="filters">
                    <h2 class="flex-column"><a href="index.php">FILTREERI</a></h2>
                    <form  class = "ul flex-column" method="POST" action="">
                        <input id="clothes" name="riided" type="submit" value="RIIDED"><?php echo file_get_contents("../txt/clothesCounter.txt"); ?>
                        <input id="technology" name="tehnika" type="submit" value="TEHNIKA"><?php echo file_get_contents("../txt/technoCounter.txt"); ?>
                        <input id="other" name="muu" type="submit" value="MUU"><?php echo file_get_contents("../txt/otherCounter.txt"); ?>
                    </form>
                </div>

                <div class="objects flex-column">

                    <?php 
                        echo $notice;
                    ?>
                    
                </div>
            </div><!--flex-row -->

        </div> <!--main section -->

    </div><!-- main-flex-->
    
</body>