<?php
    function getSuccessfulAuctions(){
        $monthsET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
        $notice = null;
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]); 
        $stmt = $conn->prepare("SELECT found_item_ad_ID, description, picture, storage_place_name FROM FOUND_ITEM_AD JOIN STORAGE_PLACE ON 
        FOUND_ITEM_AD.STORAGE_PLACE_storage_place_ID = STORAGE_PLACE.storage_place_ID WHERE expired = 1 AND auctioned = 1 ");

        echo $conn->error;
        $stmt->bind_result($id, $description, $pic, $storage_place);
        $stmt->execute();

        while($stmt->fetch()){
            $isAuctionExpired = checkIfExpiredAuction($id);
            $auctionID = getAuctionIDAdmin($id);
            echo $auctionID;
            if($isAuctionExpired == 1){
                $email = getBidEmail($auctionID);
                echo $email;
                if($email != "lostandfound@tlu.ee"){
                    $bestOffer = getHighestBid($auctionID);
                    $notice .= ' <div class="product flex-row" >';
                    $notice .= '<img class="productImageBox" src="' .$GLOBALS["pic_read_dir_thumb"] .$pic .'">';
                    $notice .= '<div class="productDesc">';
                    $notice .= '<p class="text">Kirjeldus: ' .$description .'</p>';
                    $notice .= '<p class="text">Hoiupaik: ' .$storage_place .'</p>';
                    $notice .= '<p class="text">E-mail: ' .$email .'</p>';
                    $notice .= '<p class="text">Parim pakkumine: ' .$bestOffer .'</p>';
                    $notice .= '</div></div>';
                }
            }
        }

        $stmt->close();
		$conn->close();
		return $notice;
    }

    function checkIfExpiredAuction($id){
        $notice = null;
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]); 
        $stmt = $conn->prepare("SELECT expired FROM AUCTION WHERE FOUND_ITEM_AD_found_item_ad_ID = '{$id}' ");

        echo $conn->error;
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

    function getAuctionIDAdmin($id){
        $notice = null;
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]); 
        $stmt = $conn->prepare("SELECT auction_ID FROM AUCTION WHERE FOUND_ITEM_AD_found_item_ad_ID = ? ");

        echo $conn->error;
        $stmt->bind_param("i", $id);
        $stmt->bind_result($id);
        $stmt->execute();

        if($stmt->fetch()){
            $notice = $id;
        }

        $stmt->close();
		$conn->close();
		return $notice;
    }

    function getBidEmail($id){
        $notice = null;
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]); 
        $stmt = $conn->prepare("SELECT email FROM OFFER WHERE AUCTION_auction_ID = ?");

        echo $conn->error;
        $stmt->bind_param("i", $id);
        $stmt->bind_result($email);
        $stmt->execute();

        if($stmt->fetch()){
            $notice = $email;
        }

        $stmt->close();
        $conn->close();
        return $notice;

    }

    function getHighestBid($id){
        $notice = null;
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]); 
        $stmt = $conn->prepare("SELECT offer FROM OFFER WHERE AUCTION_auction_ID = ?");

        echo $conn->error;
        $stmt->bind_param("i", $id);
        $stmt->bind_result($highestBid);
        $stmt->execute();

        if($stmt->fetch()){
            $notice = $highestBid;
        }

        $stmt->close();
        $conn->close();
        return $notice;
    }

