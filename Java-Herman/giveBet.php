<?php
require("../../../config_vp2019.php");
  require("oksjon_functions.php");
  require('head.php'); 
  //require("classes/Test.class.php");
  require("classes/Picupload.class.php");
  $database = "if19_herman_pe_1";
  require("classes/Session.class.php");
  $notice = null;
  $fileSizeLimit = 2500000;
  $maxPicW = 600;
  $maxPicH = 400;
  $fileNamePrefix = "vp_";
  $waterMarkFile = "../vp_pics/vp_logo_w100_overlay.png";
  $startingPrice=0.5;
  $picid = null;
  $return = null;
  $notice = null;
  $delnotice = null;

  if(isset($_GET["photoid"])){
    //echo $_GET["photoid"];
    $picid = $_GET["photoid"];
    $userPicHTML = chooseOne($_GET["photoid"]);
} elseif(isset($_POST["picid"])){
    $picid = $_POST["picid"];
    $userPicHTML = chooseOne($_POST["picid"]);
} else {
    $userPicHTML = null;
}

$compare = getPreviousPrice($picid);
if(isset($_POST["submitPrice"])){
    $studentId = ($_POST["studentId"]);
    $studentName =($_POST["nameOfStudent"]);
    $newPrice =($_POST["newPrice"]);
	  if((!empty($newPrice ))&&(!empty($studentId))&&(!empty($studentName))){
        if($newPrice>$compare){$notice = setPrice($studentId,$studentName,$newPrice,$_GET["item"]);}else{
            $notice = "Su pakkutud hind on väiksem praegusest";
        }
        
  } else {
		$notice = "Täida kõik lahtrid ära";
	  }
  }
  ?>

<hr>
  <div class="main-flex header">
    <div class="aside"></div>
    <!-- HEADER -->
    <div class="main-section">
        <?php require('header.php'); ?>
    </div>
    <div class="aside"></div>
 </div>
 
		<div id="payME">
            <?php
            echo $userPicHTML;
            ?>
		</div>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  <label> Tudengi ID: </label>
      <br>
      <input type="text" name="studentId">
      <br>
      <label> Nimi: </label>
      <br>
      <input type="text" name="nameOfStudent">
      <br>
      <label> Pakumine: </label>
      <br>
      <input type="text" name="newPrice">
	  <br>
      <br>
	  <input name="submitPrice" type="submit" value="Esita Pakumine">
      <?php
		if(!empty($userPicHTML)){
			echo '<input name="picid" type="hidden" value="' .$picid .'">';
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
</body>
</html>