<?php
    require("../head.php");

    $filter = null;
    $notice = null;
    $url = "new_lost.php";

/*  // Praegu ei toota sest pole andmebaasi
    if (isset($_POST["tehnika"])){
        $filter = 'tehnika';
        $notice = displayLostItems($filter);
    }elseif (isset($_POST["muu"])){
        $filter = 'muu';
        $notice = displayLostItems($filter);
    }elseif (isset($_POST["riided"])){
        $filter = 'riided';
        $notice = displayLostItems($filter);
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

        
            <?php require("../filter.php") ?>

        </div> <!--main section -->

    </div><!-- main-flex-->
    
</body>