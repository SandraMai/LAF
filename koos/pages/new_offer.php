<?php 

require('../head.php');
$database = "if19_LAF";
$notice=null;
$return = null;
$start = auctionDefaultStartPrice();



$neededNumber = getAuctionId($_GET["item"]);
if(isset($_GET["item"])){
    //echo $_GET["photoid"];
    $auctionedItem = $_GET["item"];
    $userPicHTML = getAuctionElements($_GET["item"]);
} elseif(isset($_POST["item"])){
    $auctionedItem = $_POST["item"];
    $userPicHTML = getAuctionElements($_POST["item"]);
} else {
    $userPicHTML = null;
}

$compare = priceBoundary($_GET["item"]);
$stepPrice=auctionItemStep($_GET["item"]);
$maxbid=$stepPrice*10+$compare;


if(isset($_POST["submitPrice"])){
    $email = ($_POST["email"]);
    $notification =($_POST["notification"]);
    $offer =($_POST["offer"]);
	if((!empty($offer))&&(!empty($email))){
        if($offer>$compare){$notice = setFirstBid($email,$notification,$offer,$neededNumber,$maxbid,$compare);}else{
            $notice = "Su pakkutud hind on väiksem praegusest";
        
    }
	} else {
		$notice = "Täida kõik lahtrid ära";
	}
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

                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?item=".$_GET["item"];?>">
                <label> E-Mail: </label>
                <br>
                <input type="text" name="email">
                <br>
                <label> Soovin teavitusi valitud oksjonile: </label>
                <br>
                <input type="checkbox" name="notification" value="1">
                <br>
                <label> Pakumine: </label>
                <br>
                <input type="number"  class="size-36" value="<?php echo $compare;?>" min="<?php echo $compare;?>" max="<?php echo $maxbid;?>" step="<?php echo auctionItemStep($_GET["item"]); ?>" name="offer">
                <br>
                <br>
                <input name="submitPrice" type="submit" value="Esita pakkumine">



                <?php
		if(!empty($userPicHTML)){
			echo '<input name="item" type="hidden" value="' .$_GET["item"] .'">';
			echo '<input name="return" type="hidden" value="' .$return .'">'; 
			echo "<br>";
			echo $notice;
			echo "</span> \n";
		} else {
			echo "<p>Pildi laadimisel tekkis viga!</p> \n";
		}
	?>
	</form>
        </div>
        <div class="aside"></div>
    </div>
    <script src="../js/timer.js"></script>
    <script src="../js/script.js"></script>
    </body>
    </html>