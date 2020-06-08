<?php
function submitLostItem($fileName,$date,$itemName,$category,$description,$storedArea,$startingPrice,$auctioned,$status){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("INSERT INTO oksjon1 (picture, created, itemName, category, description, stored, price,auctioned,status) VALUES (?,?,?,?,?,?,?,?,?)");
		echo $conn->error;
		$stmt->bind_param("ssssssdss",$fileName,$date,$itemName,$category,$description,$storedArea,$startingPrice,$status,$auctioned);
		if($stmt->execute()){
			$notice = " Pildi andmed salvestati andmebaasi!";
		} else {
			$notice = " Pildi andmete salvestamine ebaönnestus tehnilistel põhjustel! " .$stmt->error;
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}
	function readAuctionPics($typeOfFilter){
		$picHTML = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		if($typeOfFilter==null){
			$stmt = $conn->prepare("SELECT id,picture, created, Lisatud_KPV, itemName, category, description, stored, price FROM oksjon1 WHERE auctioned='Ja' AND status='Leitud' AND deleted IS NULL");
		}else{
			$stmt = $conn->prepare("SELECT id,picture, created, Lisatud_KPV, itemName, category, description, stored, price FROM oksjon1 WHERE auctioned='Ja' AND status='Leitud' AND category='{$typeOfFilter}' AND deleted IS NULL");
		}
		echo $conn->error;
		$stmt->bind_result($id,$pictureFromDb, $createdFromDb, $addedFromDb,$itemNameFromDb,$categoryFromDb,$descriptionFromDb,$storedFromDb,$priceFromDb);
		$stmt->execute();
		while($stmt->fetch()){
			$timestamps = strtotime($addedFromDb);
			$echoing=htmlspecialchars($_SERVER["PHP_SELF"]);
			$addedFromDb=date("d m y", strtotime("$addedFromDb +6 days"));
			$createdFromDb=date("d m y", strtotime("$createdFromDb"));
			
			$picHTML .= '<br><div class="singleP" onlckick:"">
			<div class="child inline-block-child">
				<img class="thumbs" src="' .$GLOBALS["pic_upload_dir_orig"] .$pictureFromDb .'" alt="" data-fn="' .$pictureFromDb .'" style="">
			</div>
			<div class="child inline-block-child">
			<li id="productexplinations">'."Leitud kuupäev: ".$createdFromDb.'</li>
			<li class="productexplinationsDATE" data-time="' . $timestamps . '">  <span class="days"></span>days
			<span class="hours"></span>hours
			<span class="minutes"></span>minutes
			<span class="seconds"></span>seconds</li>
			<li id="productexplinations">'."Ese: ".$itemNameFromDb.'</li>
			<li id="productexplinations">'."Kategooria: ".$categoryFromDb.'</li>
			<li id="productexplinations">'."Kirjeldus: ".$descriptionFromDb.'</li>
			<li id="productexplinations">'."Asub hoiupaigas: ".$storedFromDb.'</li>
			<li id="productexplinations">'."Oksjoni hind: ".$priceFromDb."€".'</li>
			<input type="submit" name="idofItem" value="'.$id.'" hidden>
			<li id="productexplinations"><a href="giveBet.php?photoid=' .$id .'"><input type="submit" id="priceSuggested" name="priceSuggested" value="Paku enda hind"></a><li>
			</div>
		</div>';
		}
		if($picHTML == null){
			$picHTML = "<p>Kahjuks hetkel pole ühtegi aktiivset oksjoni kuulutust</p>";
		}
		
		$stmt->close();
		$conn->close();
		return $picHTML;
	}

/*
	function deletePic($picid, $return){
		//echo "Kustuta: " .$picid;
		$notice = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("UPDATE vpphotos1 SET deleted = NOW() WHERE id = ?");
		$stmt->bind_param("i", $picid);
		echo $conn->error;
		if($stmt->execute()){
			$notice = "Kustutatud!";
		} else {
			$notice = "Kustutamisel tekkis tehniline viga: " .$stmt->error;
		}
		$stmt->close();
		$conn->close();
		if($notice == "Kustutatud!"){
			header("Location: userpics.php?page=" .$return);
			exit();
		}
		return $notice;
	}
*/
	
	function setPrice($studentId,$studentName,$newPrice,$picid){
		$notice = null;
		//echo "Muuda: " .$altText;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("UPDATE oksjon1 SET tudengiKood=?,ownerByBet=?,price = ? WHERE 	id=?");
		$stmt->bind_param("ssdi",$studentId,$studentName,$newPrice,$picid);
		echo $conn->error;
		if($stmt->execute()){
			$notice = "Pakkumine edukalt lisatud";
		} else {
			$notice = "Muutmisel tekkis tehniline viga: " .$stmt->error;
		}
		$stmt->close();
		$conn->close();
		return $notice;
		
	}

	function chooseOne($id){
		$picHTML = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT picture, created, Lisatud_KPV, itemName, category, description, stored, price FROM oksjon1 WHERE auctioned='Ja' AND status='Leitud' AND id='{$id}' AND deleted IS NULL");
		echo $conn->error;
		$stmt->bind_result($pictureFromDb, $createdFromDb, $addedFromDb,$itemNameFromDb,$categoryFromDb,$descriptionFromDb,$storedFromDb,$priceFromDb);
		$stmt->execute();
		while($stmt->fetch()){
			$timestamps = strtotime($addedFromDb);
			$echoing=htmlspecialchars($_SERVER["PHP_SELF"]);
			$addedFromDb=date("d m y", strtotime("$addedFromDb +6 days"));
			$createdFromDb=date("d m y", strtotime("$createdFromDb"));
			
			$picHTML .= '<br><div class="singleP" onlckick:"">
			<div class="child inline-block-child">
				<img class="thumbs" src="' .$GLOBALS["pic_upload_dir_orig"] .$pictureFromDb .'" alt="" data-fn="' .$pictureFromDb .'" style="">
			</div>
			<div class="child inline-block-child">
			<li id="productexplinations">'."Leitud kuupäev: ".$createdFromDb.'</li>
			<li class="productexplinationsDATE" data-time="' . $timestamps . '">  <span class="days"></span>days
			<span class="hours"></span>hours
			<span class="minutes"></span>minutes
			<span class="seconds"></span>seconds</li>
			<li id="productexplinations">'."Ese: ".$itemNameFromDb.'</li>
			<li id="productexplinations">'."Kategooria: ".$categoryFromDb.'</li>
			<li id="productexplinations">'."Kirjeldus: ".$descriptionFromDb.'</li>
			<li id="productexplinations">'."Asub hoiupaigas: ".$storedFromDb.'</li>
			<li id="productexplinations">'."Oksjoni hind: ".$priceFromDb."€".'</li>
			<input type="submit" name="idofItem" value="'.$id.'" hidden>
			<li id="productexplinations"><a href="giveBet.php?photoid=' .$id .'"><input type="submit" id="priceSuggested" name="priceSuggested" value="Paku enda hind"></a><li>
			</div>
		</div>';
		}
		if($picHTML == null){
			$picHTML = "<p>Kahjuks hetkel pole ühtegi aktiivset oksjoni kuulutust</p>";
		}
		
		$stmt->close();
		$conn->close();
		return $picHTML;
	}
	function getPreviousPrice($picid){
		$picHTML = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT price FROM oksjon1 WHERE auctioned='Ja' AND status='Leitud' AND id='{$picid}' AND deleted IS NULL");
		echo $conn->error;
		$stmt->bind_result($priceFromDb);
		$stmt->execute();
		while($stmt->fetch()){
			$picHTML .= $priceFromDb;
		}
		if($picHTML == null){
			$picHTML = "<p>Kahjuks hetkel pole ühtegi aktiivset oksjoni kuulutust</p>";
		}
		
		$stmt->close();
		$conn->close();
		return $picHTML;
	}

		function countFilters($typeOfFilter){	
				$amount = null;
				$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
			if($typeOfFilter!=null){	
				$stmt = $conn->prepare("SELECT COUNT(*) FROM oksjon1 WHERE auctioned='Ja' AND status='Leitud' AND category='{$typeOfFilter}' AND deleted IS NULL");
				
			}else{
				$stmt = $conn->prepare("SELECT COUNT(*) FROM oksjon1 WHERE auctioned='Ja' AND status='Leitud'  AND deleted IS NULL");
			}
			echo $conn->error;
				$stmt->bind_result($totalValue);
				$stmt->execute();
				while($stmt->fetch()){
					$amount .= '<li id="productexplinations">'."Ese: ".$totalValue.'</li>';
				}
				$stmt->close();
				$conn->close();
				return $amount;
	}
?>