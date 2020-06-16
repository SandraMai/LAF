<?php 

require('../head.php');
$database = "if19_LAF";
$notice=null;
$return = null;
$searchedName=null;
$searchedCategory=null;
$searchedArea=null;
$thisLink=null;
$start = auctionDefaultStartPrice();



$neededNumber = getAuctionId($_GET["item"]);
if(isset($_GET["item"])){
    //echo $_GET["photoid"];
    $auctionedItem = $_GET["item"];
    $userPicHTML = getAuctionElements($_GET["item"],$searchedName,$searchedCategory,$searchedArea,$thisLink);
} elseif(isset($_POST["item"])){
    $auctionedItem = $_POST["item"];
    $userPicHTML = getAuctionElements($_POST["item"],$searchedName,$searchedCategory,$searchedArea,$thisLink);
} else {
    $userPicHTML = null;
}

$compare = priceBoundary($_GET["item"]);
$stepPrice=auctionItemStep($_GET["item"]);
$maxbid=$stepPrice*10+$compare;




if(isset($_POST["submitPrice"])){

    $notification = 1;
    if (!isset($_POST["notification"]) ) {
        $notification = null;
    } 
    
    $email = ($_POST["email"]);
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


    <?php require('../header.php'); ?>
    

    
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
            
            
            
                </div><!--.products -->
                <?php echo $userPicHTML;?>

                <form name="add_new_offer" class="flex-column auctionForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?item=".$_GET["item"];?>">

                    <div class="error-email"></div>
                    <label class="foundLabel"> 
                        <p>E-Mail:</p>
                        <input  class="foundInput textInput inputBoxStyle" type="text" name="email">
                    </label>

                    <br>
        
                    <br>

                    <label class="foundLabel checkboxLabel"> 
                        <p>Soovin teavitusi valitud oksjonile: </p>
                        <input class="checkboxInput" type="checkbox" name="notification" value="1">
                    </label>

                    <br>


                    <div class="error-offer"></div>
                    <label class="foundLabel"> 
                        <p>Pakkumine: </p>
                        <input class="foundInput textInput inputBoxStyle numberInput" type="number" class="size-36" value="<?php echo $compare;?>" min="<?php echo $compare;?>" max="<?php echo $maxbid;?>" step="<?php echo auctionItemStep($_GET["item"]); ?>" name="offer">
                    </label>


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
                    } ?>

                </form>

        </div>
        <div class="aside"></div>
    </div>
    <!-- <script src="../js/newOffer.js"></script> -->
    <script src="../js/timer.js"></script>

    </body>
    </html>