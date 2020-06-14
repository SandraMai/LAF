<?php
	function getAuctionElements($auctionListing){
		$monthsET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
		$response = null;
		$expiredElement;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]); 
		if($auctionListing==null){
			$stmt = $conn->prepare("SELECT found_item_ad_ID,description,DATE_FORMAT(found_date, '%d'), DATE_FORMAT(found_date, '%c'), DATE_FORMAT(found_date, '%Y'),picture,CATEGORY_category_ID,place_found 
			FROM FOUND_ITEM_AD WHERE expired=1 AND auctioned=1");
			echo $conn->error;
			$stmt->bind_result($id,$description, $day, $month, $year, $picture, $CATEGORY_category_ID, $place_found);
			$stmt->execute();

			while($stmt->fetch()){
			$auctionID=getAuctionId($id);
			$checkIfactive=getAuctionExpiration($auctionID);		
			if($checkIfactive!=1){
				$timestamps = getAuctionCountdown($id);
				$echoing=htmlspecialchars($_SERVER["PHP_SELF"]);
				$response .= ' <div class="product">';
				$response .= '<span class="productImageBox"><img class="productImage" src="' .$GLOBALS["pic_read_dir_thumb"] . $picture  . '"></span>';
				$response .= '<div class="productDesc">';
				$response .= '<p>Kirjeldus: ' . $description . '</p>';
				$response .= '<p>Leidmise koht: ' . $place_found . '</p>';
				$response .= '<p>Leitud kuupäev: ' .$day .'.' .$monthsET[$month] .' ' .$year .'</p>';
				$response .= '<br><p>Aegub ';
				$response .= '<a class="productexplinationsDATE" data-time="' . $timestamps . '">';
				$response .= '<span class="days"></span> p <span class="hours"></span> h <span class="minutes">';
				$response .= '</span> min <span class="seconds"></span> s </a></p>';
				$response .= '<p><a class="newOffer" href="new_offer.php?item='.$id.'">';
				$response .= '<input type="submit" id="priceSuggested" name="priceSuggested" value="Paku enda hind"></a></p>';
				$response .= '</div><div class="aside"></div></div>';
			}
			}
			$stmt->close();
			$conn->close();
			return $response;
		}
        else if($auctionListing!=NULL){
			$stmt = $conn->prepare("SELECT found_item_ad_ID,description,DATE_FORMAT(found_date, '%d'), DATE_FORMAT(found_date, '%c'), DATE_FORMAT(found_date, '%Y'),picture,CATEGORY_category_ID,place_found FROM FOUND_ITEM_AD WHERE expired=1 AND auctioned=1 AND found_item_ad_ID='{$auctionListing}' ");
			echo $conn->error;
			$stmt->bind_result($id,$description, $day, $month, $year, $picture, $CATEGORY_category_ID, $place_found);
			$stmt->execute();

			while($stmt->fetch()){
			$timestamps = getAuctionCountdown($id);
			$currentBestBid=priceBoundary($id);
			$echoing=htmlspecialchars($_SERVER["PHP_SELF"]);
			$response .= ' <div class="product">';
			$response .= '<span class="productImageBox"><img class="productImage" src="' .$GLOBALS["pic_read_dir_thumb"] . $picture  . '"></span>';
			$response .= '<div class="productDesc">';
			$response .= '<p>Kirjeldus: ' . $description . '</p>';
			$response .= '<p>Leidmise koht: ' . $place_found . '</p>';
			$response .= '<p>Leitud kuupäev: ' .$day .'.' .$monthsET[$month] .' ' .$year .'</p>';
			$response .= '<p>Hetkel parim pakkumine: ' . $currentBestBid. ' €</p>';
			$response .= '<p>Aegub ';
			$response .= '<a class="productexplinationsDATE" data-time="' . $timestamps . '">';
			$response .= '<span class="days"></span> p <span class="hours"></span> h <span class="minutes">';
			$response .= '</span> min <span class="seconds"></span> s </a></p>';
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
	function getAuctionExpiration($idofItem){

		$expiredElement=null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT expired from AUCTION WHERE auction_ID='{$idofItem}' ");
		echo $conn->error;
		$stmt->bind_result($expiredFromDB);
		$stmt->execute();
		while($stmt->fetch()){
			$expiredElement = $expiredFromDB;
			}
	
		$stmt->close();
		$conn->close();
		return $expiredElement;;
		}
	function setFirstBid($email,$notification,$offer,$idofAuctionedItem){
		$response = null;
		$expiredElement;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]); 
		$stmt = $conn->prepare("UPDATE  OFFER SET email=?,notification=?,offer=? WHERE AUCTION_auction_ID='{$idofAuctionedItem}'");
		$stmt->bind_param("sid",$email,$notification,$offer);
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
		function priceBoundary($auctionedItem){
		$notice = null;
		//echo "Muuda: " .$altText;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT auction_ID FROM AUCTION WHERE FOUND_ITEM_AD_found_item_ad_ID='{$auctionedItem}'");
		echo $conn->error;
		$stmt->bind_result($auctionFromDb);
		$stmt->execute();
		if($stmt->fetch()){
            $currentAuction=$auctionFromDb;
        } else {
            $notice = "ei toimi";
        }
		$stmt->close();
		$stmt = $conn->prepare("SELECT offer FROM OFFER WHERE AUCTION_auction_ID='{$currentAuction}'");
		echo $conn->error;
		$stmt->bind_result($offerFromDb);
		$stmt->execute();
		if($stmt->fetch()){
            $currentOffer=$offerFromDb;
        } else {
            $notice = "ei toimi";
        }
		$stmt->close();
		$conn->close();
		return $currentOffer;
	}
	function getAuctionId($auctionedItem){
		$notice = null;
		//echo "Muuda: " .$altText;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT auction_ID FROM AUCTION WHERE FOUND_ITEM_AD_found_item_ad_ID='{$auctionedItem}'");
		echo $conn->error;
		$stmt->bind_result($auctionFromDb);
		$stmt->execute();
		if($stmt->fetch()){
            $currentAuction=$auctionFromDb;
        } else {
            $notice = "ei toimi";
        }
		$stmt->close();
		$conn->close();
		return $currentAuction;
	}
	function auctionItemStep($id){
        $step = null;
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("SELECT step FROM AUCTION WHERE FOUND_ITEM_AD_found_item_ad_ID='{$id}'");
        $stmt->bind_result($stepDB);
        $stmt->execute();
        if($stmt->fetch()){
          $step = $stepDB;
        } else {
          $step = $stmt->error;
        }
        $stmt->close();
        $conn->close();
        return $step;
	}
?>