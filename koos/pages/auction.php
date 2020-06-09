<?php require('../head.php'); 
require("../functions/oksjon_functions.php");
require("../../../../config_laf.php");
/*require("functions_user.php");
require("functions_main.php");
require("functions_pic.php");*/
$database = "if19_LAF";

?>
<body>
    
<div class="main-flex header">
    <div class="aside"></div>
    <!-- HEADER -->
    <div class="main-section">
        <?php require('../header.php'); ?>
    </div>
    <div class="aside"></div>
</div>
<div class="main-flex">
    <div class="aside"></div>
    <div class="main-section">
        <!-- HERO TEXT  -->
        <div class="flex-row"> 
            <h1 class="title">OKSJON</h1>
        </div>
        <!-- HERO BUTTON  -->
        <div class="flex-row"> 
        </div>
        <!-- PAGE NUMBERS -->
        <div class="flex-row"> 
            <div class="aside"></div>
            <div>                
                <?php
                echo "Tänane kuupäev " . date("Y/m/d") . "<br>";
                ?></div>
        </div>
        <!-- PAGE BODY -->
        <?php 
            require("../filter.php");
        ?>
    </div>
    <div class="aside"></div>
</div>
<script src="../js/timer.js"></script>
<script src="../js/script.js"></script>
</body>
</html>