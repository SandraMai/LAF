<?php
    

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

