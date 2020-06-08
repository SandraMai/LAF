<?php
  require("../../../config_vp2019.php");
  require("oksjon_functions.php");
  require('head.php'); 
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
  
	if(isset($_POST["submitPic"]) and !empty($_FILES["fileToUpload"]["name"])) {

		$myPic = new Picupload($_FILES["fileToUpload"], $fileSizeLimit);
		if($myPic->error == null){

			$myPic->createFileName($fileNamePrefix);
			$notice .= " " .$myPic->saveOriginal($pic_upload_dir_orig .$myPic->fileName);
						
			$notice .= submitLostItem($myPic->fileName, $_POST["date"],$_POST["itemName"],$_POST["category"],$_POST["description"],$_POST["storedArea"],$startingPrice,$_POST["status"],$_POST["oksjon"]);
		} else {
			if($myPic->error == 1){
				$notice = "Üleslaadimiseks valitud fail pole pilt!";
			}
			if($myPic->error == 2){
				$notice = "Üleslaadimiseks valitud fail on liiga suure failimahuga!";
			}
			if($myPic->error == 3){
				$notice = "Üleslaadimiseks valitud fail pole lubatud tüüpi (lubatakse vaid jpg, png ja gif)!";
			}
		}
		unset($myPic);
	}
  
  
  $toScript = "\t" .'<script type="text/javascript" src="javascript/checkFileSize.js" defer></script>' ."\n";
?>
  <hr>
  <div class="main-flex header">
    <div class="aside"></div>
    <div class="main-section">
        <?php require('header.php'); ?>
    </div>
    <div class="aside"></div>
</div>
	
		<div id="submitItem">
				<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
					<label>Registreeri kaotatud ese!</label><br>
					<input type="file" name="fileToUpload" id="fileToUpload">
					<br>
					<label>Leidmise kuupäev
								<input type="date" name="date">
					</label>
					<br>
					<br>
					<label>Ese nimetus</label><input type="text" name="itemName">
					<br>
					<label>Kategooria</label>
					<br>
					<input type="radio" name="category" value="Riided"><label>Riided</label>&nbsp;
					<input type="radio" name="category" value="Tehnika"><label>Tehnika</label>&nbsp;
					<input type="radio" name="category" value="Muu" checked><label>Muu</label>
					<br>
					<br>
					<label>Kirejldus</label><textarea name="description"></textarea>
					<br>
					<br>
					<label>Hoiupaik</label>
					<br>
					<input type="radio" name="storedArea" value="Nova"><label>Nova</label>&nbsp;
					<input type="radio" name="storedArea" value="Ursa"><label>Ursa</label>&nbsp;
					<input type="radio" name="storedArea" value="Terra"><label>Terra</label>&nbsp;
					<input type="radio" name="storedArea" value="Astra"><label>Astra</label>&nbsp;
					<input type="radio" name="storedArea" value="Silva"><label>Silva</label>&nbsp;
					<input type="radio" name="storedArea" value="Mare"><label>Mare</label>&nbsp;
					<br>
					<label>On oksjonil</label>
					<br>
					<input type="radio" name="oksjon" value="Ja"><label>Ja</label>&nbsp;
					<input type="radio" name="oksjon" value="Ei"><label>Ei</label>&nbsp;
					<br>
					<label>Kas oli leitud või kaotatud ese</label>
					<br>
					<input type="radio" name="status" value="Kaotatud"><label>Kaotatud</label>&nbsp;
					<input type="radio" name="status" value="Leitud"><label>Leitud</label>&nbsp;
					<br>
					<input name="submitPic" id="submitPic" type="submit" value="Lae pilt üles!"><span id="notice"><?php echo $notice; ?></span>
				</form>
				<hr>
			</div>
		</div>
	</div>
</body>
</html>