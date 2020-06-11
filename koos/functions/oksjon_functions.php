<?php
	function getAuctionElements($auctionListing){
		$response = null;
		$expiredElement;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]); 
		if($auctionListing==null){
			$stmt = $conn->prepare("SELECT found_item_ad_ID,description,found_date,picture,CATEGORY_category_ID,place_found FROM FOUND_ITEM_AD WHERE expired=1 AND auctioned=1");
			echo $conn->error;
			$stmt->bind_result($id,$description, $found_date, $picture, $CATEGORY_category_ID, $place_found);
			$stmt->execute();

			while($stmt->fetch()){
			$timestamps = getAuctionCountdown($id);
			$echoing=htmlspecialchars($_SERVER["PHP_SELF"]);
			$response .= ' <div class="product flex-row">';
			$response .= '<img class="productImage" src="' .$GLOBALS["pic_read_dir_thumb"] . $picture  . '">';
			$response .= '<div class="flex-column productDesc">';
			$response .= '<p>Kirjeldus: ' . $description . '</p>';
			$response .= '<p>Leidmise koht:' . $place_found . '</p>';
			$response .= '<p>Leitud kuupäev: ' . $found_date . '</p>';
			$response .= '<br><p>Aegub</p>';
			$response .= '<a class="productexplinationsDATE" data-time="' . $timestamps . '">';
			$response .= '<span class="days"></span>days<span class="hours"></span>hours<span class="minutes">';
			$response .= '</span>minutes<span class="seconds"></span>seconds</a>';
			$response .= '<p><a href="new_offer.php?item='.$id.'">';
			$response .= '<input type="submit" id="priceSuggested" name="priceSuggested" value="Paku enda hind"></a></p>';
			$response .= '</div><div class="aside"></div></div>';

			

			}
			if($response == null){
			$response = "<p>Kahjuks hetkel pole ühtegi aktiivset oksjoni kuulutust</p>";
			}
			

			$response .= "\n";

			$stmt->close();
			$conn->close();
			return $response;
		}
		 else if($auctionListing!=NULL){
			$stmt = $conn->prepare("SELECT found_item_ad_ID,description,found_date,picture,CATEGORY_category_ID,place_found FROM FOUND_ITEM_AD WHERE expired=1 AND auctioned=1 AND found_item_ad_ID='{$auctionListing}' ");
			echo $conn->error;
			$stmt->bind_result($id,$description, $found_date, $picture, $CATEGORY_category_ID, $place_found);
			$stmt->execute();

			while($stmt->fetch()){
			$timestamps = getAuctionCountdown($id);
			$echoing=htmlspecialchars($_SERVER["PHP_SELF"]);
			$response .= ' <div class="product flex-row">';
			$response .= '<img class="productImage" src="' .$GLOBALS["pic_read_dir_thumb"] . $picture  . '">';
			$response .= '<div class="flex-column productDesc">';
			$response .= '<p>Kirjeldus: ' . $description . '</p>';
			$response .= '<p>Leidmise koht:' . $place_found . '</p>';
			$response .= '<p>Leitud kuupäev: ' . $found_date . '</p>';
			$response .= '<br><p>Aegub</p>';
			$response .= '<a class="productexplinationsDATE" data-time="' . $timestamps . '">';
			$response .= '<span class="days"></span>days<span class="hours"></span>hours<span class="minutes">';
			$response .= '</span>minutes<span class="seconds"></span>seconds</a>';
			$response .= '</div><div class="aside"></div></div>';

			

			}
			if($response == null){
			$response = "<p>Kahjuks hetkel pole ühtegi aktiivset oksjoni kuulutust</p>";
			}
			

			$response .= "\n";

			$stmt->close();
			$conn->close();
			return $response;
		}
		
	}
	function getAuctionCountdown($idofItem){

	$response = null;
	$expiredElement;
	$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT start_date from AUCTION where expired IS NULL AND 	FOUND_ITEM_AD_found_item_ad_ID='{$idofItem}' ");
	echo $conn->error;
	$stmt->bind_result($auctionActiveDate);
	$stmt->execute();
	while($stmt->fetch()){
		$timestamps = strtotime($auctionActiveDate);
		$echoing=htmlspecialchars($_SERVER["PHP_SELF"]);
		$auctionActiveDate=date("d m y", strtotime("$auctionActiveDate +6 days"));
		}
	$response .= "\n";

	$stmt->close();
	$conn->close();
	return $timestamps;
	}
	function setFirstBid($idofAuctionedItem){
		$response = null;
		$expiredElement;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]); 
			$stmt = $conn->prepare("SELECT found_item_ad_ID,description,found_date,picture,CATEGORY_category_ID,place_found FROM FOUND_ITEM_AD WHERE expired=1 AND auctioned=1");
			echo $conn->error;
			$stmt->bind_result($id,$description, $found_date, $picture, $CATEGORY_category_ID, $place_found);
			$stmt->execute();

			while($stmt->fetch()){
			$timestamps = getAuctionCountdown($id);
			$echoing=htmlspecialchars($_SERVER["PHP_SELF"]);
			$response .= ' <div class="product flex-row">';
			$response .= '<img class="productImage" src="' .$GLOBALS["pic_read_dir_thumb"] . $picture  . '">';
			$response .= '<div class="flex-column productDesc">';
			$response .= '<p>Kirjeldus: ' . $description . '</p>';
			$response .= '<p>Leidmise koht:' . $place_found . '</p>';
			$response .= '<p>Leitud kuupäev: ' . $found_date . '</p>';
			$response .= '<br><p>Aegub</p>';
			$response .= '<a class="productexplinationsDATE" data-time="' . $timestamps . '">';
			$response .= '<span class="days"></span>days<span class="hours"></span>hours<span class="minutes">';
			$response .= '</span>minutes<span class="seconds"></span>seconds</a>';
			$response .= '<p><a href="new_offer.php?item='.$id.'">';
			$response .= '<input type="submit" id="priceSuggested" name="priceSuggested" value="Paku enda hind"></a></p>';
			$response .= '</div><div class="aside"></div></div>';
			}
			

			$response .= "\n";

			$stmt->close();
			$conn->close();
			return $response;
	}

?>


