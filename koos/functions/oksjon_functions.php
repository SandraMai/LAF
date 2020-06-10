<?php
	function getAuctionElements(){
		$notice = null;
		$expiredElement;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
			$stmt = $conn->prepare("SELECT FOUND_ITEM_AD_found_item_ad_ID from AUCTION where expired=1 AND auctioned=1");
			$response = null;
			$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
			$stmt = $conn->prepare("SELECT description,found_date,picture,CATEGORY_category_ID,place_found FROM FOUND_ITEM_AD WHERE expired=1 AND auctioned=1");
			echo $conn->error;
			$stmt->bind_result($description, $found_date, $picture, $CATEGORY_category_ID, $place_found);
			$stmt->execute();
	 
			while($stmt->fetch()){
			$response .= ' <div class="product flex-row">';
			$response .= '<img class="productImage" src="' .$GLOBALS["pic_read_dir_thumb"] . $picture  . '">';
			$response .= '<div class="flex-column productDesc">';
			$response .= '<p>Kirjeldus: ' . $description . '</p>';
			$response .= '<p>Leidmise koht:' . $place_found . '</p>';
			$response .= '<p>Kuupäev: ' . $found_date . '</p>';
			$response .= '</div><div class="aside"></div></div>';
			}
	
			$response .= "\n";
	
			$stmt->close();
			$conn->close();
			return $response;
	}
?>
