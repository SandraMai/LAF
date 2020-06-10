<?php
	function auctionFiltration(){
		$notice = null;
		$expiredElement;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
			$stmt = $conn->prepare("SELECT found_item_ad_ID from FOUND_ITEM_AD where expired=1 AND auctioned IS NULL");
		echo $conn->error;
		$stmt->bind_result($expiredItemID);
		$stmt->execute();
		if($stmt->fetch()){
            $expiredElement = $expiredItemID;
        } else {
            $notice = "ei toimi";
        }
		
		$stmt->close();   
  
        $stmt = $conn->prepare("INSERT INTO AUCTION (FOUND_ITEM_AD_found_item_ad_ID) VALUES(?)");
        echo $conn->error;
        $stmt->bind_param("i",$expiredElement);
        if($stmt->execute()){
            $notice = 1;
        } else {
            $notice = 0;
        }

		$stmt->close();
		$stmt = $conn->prepare("UPDATE  FOUND_ITEM_AD SET auctioned=1 WHERE  found_item_ad_ID='{$expiredElement}' ");
		if($stmt->execute()){
            $notice = "Tehtud!";
        }else{
            $notice = "Salvestamisel tekkis tehniline tõrge: " .$stmt->error;
        }
        $stmt->close();
        $conn->close();
        return $notice;
	}
?>
