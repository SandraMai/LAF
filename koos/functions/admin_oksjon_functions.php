<?php
    function getSuccessfulAuctions(){
        $monthsET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
        $notice = null;
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]); 
        $stmt = $conn->prepare("SELECT found_item_id, description, picture, storage_place_name FROM FOUND_ITEM_AD JOIN STORAGE_PLACE ON 
        FOUND_ITEM_AD.STORAGE_PLACE_storage_place_ID = STORAGE_PLACE.storage_place_ID WHERE expired = 1 AND auctioned = 1 ");

        echo $conn->error;
        $stmt->bind_result($id, $description, $pic, $storage_place);
        $stmt->execute();

        while($stmt->execute()){
            $isAuctionExpired = checkIfExpiredAuction($id);
            $auctionID = getAuctionID($id);
        }
    }

    function checkIfExpiredAuction($id){
        $notice = null;
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]); 
        $stmt = $conn->prepare("SELECT expired FROM AUCTION WHERE FOUND_ITEM_AD_found_item_ad_ID = ? ");

        echo $conn->error;
        $stmt->bind_param("i", $id);
        $stmt->bind_result($result);
        $stmt->execute();

        if($stmt->fetch()){
            if($result == 1){
                $notice = 1;
            }else{
                $notice = 0;
            }
        }

        $stmt->close();
		$conn->close();
		return $notice;
    }

    function getAuctionID($id){
        $notice = null;
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]); 
        $stmt = $conn->prepare("SELECT auction_ID FROM AUCTION WHERE FOUND_ITEM_AD_found_item_ad_ID = ? ");

        echo $conn->error;
        $stmt->bind_param("i", $id);
        $stmt->bind_result($id);


        $stmt->close();
		$conn->close();
		return $notice;
    }
