<?php require('../head.php'); 
require("../functions/oksjon_functions.php");
require("../../../../config_laf.php");
/*require("functions_user.php");
require("functions_main.php");
require("functions_pic.php");*/
$database = "if19_LAF";



if(isset($_GET["item"])){
    //echo $_GET["photoid"];
    $picid = $_GET["item"];
    $userPicHTML = getAuctionElements($_GET["item"]);
} elseif(isset($_POST["item"])){
    $picid = $_POST["item"];
    $userPicHTML = getAuctionElements($_POST["item"]);
} else {
    $userPicHTML = null;
}



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
    
    <div class="main-flex page-body">
        <div class="aside"></div>
        <div class="main-section">
            <!-- HERO TEXT  -->
            <div class="flex-row"> 
                <h1 class="title">OKSJON</h1>
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
            <div class="flex-row"> 
            
            
            
      <?php?>
                </div><!--.products -->
                <?php echo $userPicHTML;?>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <label> E-Mail: </label>
                <br>
                <input type="text" name="email">
                <br>
                <label> Teavitused: </label>
                <br>
                <input type="checkbox" name="notifications" value="1">
                <br>
                <label> Pakumine: </label>
                <br>
                <input type="text" name="newPrice">
                <br>
                <br>
                <input name="submitPrice" type="submit" value="Esita Pakumine">
        </div>
        <div class="aside"></div>
    </div>
    <script src="../js/timer.js"></script>
    <script src="../js/script.js"></script>
    </body>
    </html>