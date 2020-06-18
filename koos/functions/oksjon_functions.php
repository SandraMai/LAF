<?php
	function getAuctionElements($auctionListing,$searchedName,$searchedCategory,$searchedArea,$thisLink, $offset,$searchedStartDate,$searchedEndDate){
		$monthsET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
		$response = null;
		$expiredElement;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]); 

		$sqlStatementMain="SELECT found_item_ad_ID,description,DATE_FORMAT(found_date, '%d'), DATE_FORMAT(found_date, '%c'), DATE_FORMAT(found_date, '%Y'),picture,CATEGORY_category_ID,place_found FROM FOUND_ITEM_AD WHERE expired=1 AND auctioned=1 AND deleted = 0 ";
        $sqlStatementCondition=null;

        $sqlAfterStatements="";//" ORDER BY found_item_ad_ID DESC LIMIT 3 OFFSET ?";

		if($auctionListing!=NULL){
			$sqlStatementCondition=" AND found_item_ad_ID='{$auctionListing}' ";

		}
		else if($auctionListing==NULL&&$searchedName==null&&$searchedArea==null&&$searchedCategory==null&&$searchedStartDate==null&&$searchedEndDate==null){
			$sqlStatementCondition=null;
			
		}else if($auctionListing==NULL&&$searchedName!=null&&$searchedArea==null&&$searchedCategory==null&&$searchedStartDate==null&&$searchedEndDate==null){
			$sqlStatementCondition=" AND description LIKE '%{$searchedName}%' ";
		}else if($auctionListing==NULL&&$searchedName==null&&$searchedArea!=null&&$searchedCategory==null&&$searchedStartDate==null&&$searchedEndDate==null){
			$sqlStatementCondition=" AND place_found LIKE '%{$searchedArea}%' ";
		}else if($auctionListing==NULL&&$searchedName==null&&$searchedArea==null&&$searchedCategory!=null&&$searchedStartDate==null&&$searchedEndDate==null){
			$sqlStatementCondition=" AND CATEGORY_category_ID LIKE '%{$searchedCategory}%' ";
			
		}else if($auctionListing==NULL&&$searchedName!=null&&$searchedArea!=null&&$searchedCategory==null&&$searchedStartDate==null&&$searchedEndDate==null){
			$sqlStatementCondition=" AND description LIKE '%{$searchedName}%'AND place_found LIKE '%{$searchedArea}%' ";
		}else if($auctionListing==NULL&&$searchedName==null&&$searchedArea!=null&&$searchedCategory!=null&&$searchedStartDate==null&&$searchedEndDate==null){
			$sqlStatementCondition=" AND place_found LIKE '%{$searchedArea}%' AND CATEGORY_category_ID LIKE '%{$searchedCategory}%' ";
			
		}else if($auctionListing==NULL&&$searchedName!=null&&$searchedArea==null&&$searchedCategory!=null&&$searchedStartDate==null&&$searchedEndDate==null){
			$sqlStatementCondition=" AND description LIKE '%{$searchedName}%' AND CATEGORY_category_ID LIKE '%{$searchedCategory}%' ";
			
		}else if($auctionListing==NULL&&$searchedName!=null&&$searchedArea!=null&&$searchedCategory!=null&&$searchedStartDate==null&&$searchedEndDate==null){
			$sqlStatementCondition=" AND description LIKE '%{$searchedName}%'AND place_found LIKE '%{$searchedArea}%' AND CATEGORY_category_ID LIKE '%{$searchedCategory}%' ";
		}else if($auctionListing==NULL&&$searchedName==null&&$searchedArea==null&&$searchedCategory==null&&$searchedStartDate!=null&&$searchedEndDate==null){// siit algab startdate
            $sqlStatementCondition="AND found_date>='$searchedStartDate' ";

            
        }else if($auctionListing==NULL&&$searchedName!=null&&$searchedArea==null&&$searchedCategory==null&&$searchedStartDate!=null&&$searchedEndDate==null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND found_date>='$searchedStartDate'  ";
                
        }else if($auctionListing==NULL&&$searchedName==null&&$searchedArea!=null&&$searchedCategory==null&&$searchedStartDate!=null&&$searchedEndDate==null){
            $sqlStatementCondition=" AND place_found LIKE '%{$searchedArea}%' AND found_date>='$searchedStartDate'  ";
            
        }else if($auctionListing==NULL&&$searchedName==null&&$searchedArea==null&&$searchedCategory!=null&&$searchedStartDate!=null&&$searchedEndDate==null){
            $sqlStatementCondition=" AND CATEGORY_category_ID='{$searchedCategory}' AND found_date>='$searchedStartDate'  ";
            
        }else if($auctionListing==NULL&&$searchedName!=null&&$searchedArea!=null&&$searchedCategory==null&&$searchedStartDate!=null&&$searchedEndDate==null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND place_found LIKE '%{$searchedArea}%' AND found_date>='$searchedStartDate'  ";
            
        }else if($auctionListing==NULL&&$searchedName==null&&$searchedArea!=null&&$searchedCategory!=null&&$searchedStartDate!=null&&$searchedEndDate==null){
            $sqlStatementCondition=" AND place_found LIKE '%{$searchedArea}%' AND CATEGORY_category_ID='{$searchedCategory}' AND found_date>='$searchedStartDate'  ";
            
        }else if($auctionListing==NULL&&$searchedName!=null&&$searchedArea==null&&$searchedCategory!=null&&$searchedStartDate!=null&&$searchedEndDate==null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND CATEGORY_category_ID='{$searchedCategory}' AND found_date>='$searchedStartDate'  ";
            
        }else if($auctionListing==NULL&&$searchedName!=null&&$searchedArea!=null&&$searchedCategory!=null&&$searchedStartDate!=null&&$searchedEndDate==null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND place_found LIKE '%{$searchedArea}%' AND CATEGORY_category_ID='{$searchedCategory}' AND found_date>='$searchedStartDate'  ";

        
        
        }else if($auctionListing==NULL&&$searchedName==null&&$searchedArea==null&&$searchedCategory==null&&$searchedStartDate==null&&$searchedEndDate!=null){// siit end date
            $sqlStatementCondition="AND found_date<='$searchedEndDate' ";

            
        }else if($auctionListing==NULL&&$searchedName!=null&&$searchedArea==null&&$searchedCategory==null&&$searchedStartDate==null&&$searchedEndDate!=null){ 
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND found_date>='$searchedEndDate'  ";
                
        }else if($auctionListing==NULL&&$searchedName==null&&$searchedArea!=null&&$searchedCategory==null&&$searchedStartDate==null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND place_found LIKE '%{$searchedArea}%' AND found_date>='$searchedEndDate'  ";
            
        }else if($auctionListing==NULL&&$searchedName==null&&$searchedArea==null&&$searchedCategory!=null&&$searchedStartDate==null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND CATEGORY_category_ID='{$searchedCategory}' AND found_date>='$searchedEndDate'  ";
            
        }else if($auctionListing==NULL&&$searchedName!=null&&$searchedArea!=null&&$searchedCategory==null&&$searchedStartDate==null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND place_found LIKE '%{$searchedArea}%' AND found_date>='$searchedEndDate'  ";
            
        }else if($auctionListing==NULL&&$searchedName==null&&$searchedArea!=null&&$searchedCategory!=null&&$searchedStartDate==null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND place_found LIKE '%{$searchedArea}%' AND CATEGORY_category_ID='{$searchedCategory}' AND found_date>='$searchedEndDate'  ";
            
        }else if($auctionListing==NULL&&$searchedName!=null&&$searchedArea==null&&$searchedCategory!=null&&$searchedStartDate==null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND CATEGORY_category_ID='{$searchedCategory}' AND found_date>='$searchedEndDate'  ";
            
        }else if($auctionListing==NULL&&$searchedName!=null&&$searchedArea!=null&&$searchedCategory!=null&&$searchedStartDate==null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND place_found LIKE '%{$searchedArea}%' AND CATEGORY_category_ID='{$searchedCategory}' AND found_date>='$searchedEndDate'  ";
        
        }else if($auctionListing==NULL&&$searchedName==null&&$searchedArea==null&&$searchedCategory==null&&$searchedStartDate!=null&&$searchedEndDate!=null){ // end and start date
            $sqlStatementCondition="AND (found_date BETWEEN '$searchedStartDate' AND '$searchedEndDate') ";

            
        }else if($auctionListing==NULL&&$searchedName!=null&&$searchedArea==null&&$searchedCategory==null&&$searchedStartDate!=null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND (found_date BETWEEN '$searchedStartDate' AND '$searchedEndDate') ";
                
        }else if($auctionListing==NULL&&$searchedName==null&&$searchedArea!=null&&$searchedCategory==null&&$searchedStartDate!=null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND place_found LIKE '%{$searchedArea}%' AND (found_date BETWEEN '$searchedStartDate' AND '$searchedEndDate') ";
            
        }else if($auctionListing==NULL&&$searchedName==null&&$searchedArea==null&&$searchedCategory!=null&&$searchedStartDate!=null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND CATEGORY_category_ID='{$searchedCategory}' AND (found_date BETWEEN '$searchedStartDate' AND '$searchedEndDate') ";
            
        }else if($auctionListing==NULL&&$searchedName!=null&&$searchedArea!=null&&$searchedCategory==null&&$searchedStartDate!=null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND place_found LIKE '%{$searchedArea}%' AND (found_date BETWEEN '$searchedStartDate' AND '$searchedEndDate') ";
            
        }else if($auctionListing==NULL&&$searchedName==null&&$searchedArea!=null&&$searchedCategory!=null&&$searchedStartDate!=null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND place_found LIKE '%{$searchedArea}%' AND CATEGORY_category_ID='{$searchedCategory}' AND (found_date BETWEEN '$searchedStartDate' AND '$searchedEndDate') ";
            
        }else if($auctionListing==NULL&&$searchedName!=null&&$searchedArea==null&&$searchedCategory!=null&&$searchedStartDate!=null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND CATEGORY_category_ID='{$searchedCategory}' AND (found_date BETWEEN '$searchedStartDate' AND '$searchedEndDate') ";
            
        }else if($auctionListing==NULL&&$searchedName!=null&&$searchedArea!=null&&$searchedCategory!=null&&$searchedStartDate!=null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND place_found LIKE '%{$searchedArea}%' AND CATEGORY_category_ID='{$searchedCategory}' AND (found_date BETWEEN '$searchedStartDate' AND '$searchedEndDate') ";
        
        }
		
		$sqlStatementMain.=$sqlStatementCondition;
        $sqlStatementMain.=$sqlAfterStatements;
        $stmt=$conn->prepare($sqlStatementMain);
        echo $conn->error;
        $stmt->bind_param("i", $offset);
            
		echo $conn->error;
		$stmt->bind_result($id,$description, $day, $month, $year, $picture, $CATEGORY_category_ID, $place_found);
		$stmt->execute();

        while($stmt->fetch()){
            $auctionID=getAuctionId($id);
            $highestBid = getHighestBid($auctionID);
            $checkIfactive=getAuctionExpiration($auctionID);		
            if($checkIfactive!=1){
                $timestamps = getAuctionCountdown($id);
                $echoing=htmlspecialchars($_SERVER["PHP_SELF"]);
                $response .= ' <div class="product">';
                $response .= '<span class="productImageBox"><img class="productImage" src="' .$GLOBALS["pic_read_dir_thumb"] . $picture  . '"></span>';
                $response .= '<div class="productDesc">';
                $response .= '<p>Kirjeldus: ' . $description . '</p>';
                $response .= '<p>Leitud kuupäev: ' .$day .'.' .$monthsET[$month-1] .' ' .$year .'</p>';
                $response .= '<p>Viimane pakkumine: ' .$highestBid .' €</p>';
                $response .= '<p>Aegub ';
                $response .= '<a class="productexplinationsDATE" data-time="' . $timestamps . '">';
                $response .= '<span class="days"></span> p <span class="hours"></span> h <span class="minutes">';
                $response .= '</span> min <span class="seconds"></span> s </a></p>';
                if($auctionListing==null){
                    $response .= '<p class="alignToEnd"><a class="newOffer" href="new_offer.php?item='.$id.'">';
                    $response .= '<input type="submit" id="priceSuggested" name="priceSuggested" value="Paku enda hind"></a></p>';
                }
                $response .= '</div></div>';
            }
        
        }

        if($response == null){
            $response = 100;
        }
        $stmt->close();
        $conn->close();
        return $response;
		
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
		return $expiredElement;
	}

	function setFirstBid($email,$notification,$offer,$idofAuctionedItem,$maxCompared,$minCompare){
		if($offer<=$maxCompared){
			if($offer>=$minCompare){	
			$response = null;
			$expiredElement;
			$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
			$stmt = $conn->prepare("SELECT email, notification FROM OFFER WHERE AUCTION_auction_ID = '{$idofAuctionedItem}'");
			$stmt->bind_result($emailDB, $notificationDB);
			echo $conn->error;
			$stmt->execute();
			if($stmt->fetch()){
				if($notificationDB == 1){
					$description = getOfferDescription($idofAuctionedItem);
					$message = "Sinu pakkumine on üle pakutud! Ese kirjeldusega: " .$description .".";
					$message .= "\r\nÄra sellele meilile vasta! \r\n Sinu LAF ❤";
					$headers = 'Lost And Found oksjon';
					
					mail($emailDB, $headers, $message);
				}
			}
			$stmt->close();

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
			}else{
				$notice="Hind ei saa olla väiksem praegusest pakkumisest";
			return $notice;
			}
		}else{
			$notice="Hind ületab praeguse võimaliku pakkumise.";
			return $notice;
		}
	
	}

	function getOfferDescription($id){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT description FROM AUCTION JOIN FOUND_ITEM_AD ON 
		AUCTION.FOUND_ITEM_AD_found_item_ad_ID = FOUND_ITEM_AD.found_item_ad_ID WHERE auction_ID = '{$id}'");
		echo $conn->error;
		$stmt->bind_result($descriptionDB);
		$stmt->execute();
		if($stmt->fetch()){
			$notice = $descriptionDB;
		}else{
			$notice = 404;
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
	function searchedItems($searchedName,$searchedCategory,$searchedArea){
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

	function checkExpiredAuction(){
		$today = date("Y-m-d H:i:s");
		$notice = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT auction_ID, end_date, FOUND_ITEM_AD_found_item_ad_ID, winner_email_sent FROM AUCTION");
		echo $conn->error;

		$stmt->bind_result($auctionID, $endDateDB, $foundItemID, $emailSent);
		$stmt->execute();
		while($stmt->fetch()){
			if($endDateDB < $today && $emailSent == 0){
				setExpired($auctionID);
				$email = getWinnerEmail($auctionID);
				if($email != "lostandfound@tlu.ee"){
					$storage = selectStorage($foundItemID);
					$description = selectDescription($foundItemID);
					$highestBid = getHighestBid($auctionID);
					$message = "Oled võitnud oksjoni! Ese kirjeldusega: " .$description .") asub hoiupaigas: " 
					.$storage;
					$message .= ". Teie pakkumine: " .$highestBid ."€. Arveldamine käib AINULT sularahas. \r\n Ära sellele meilile vasta! \r\n Sinu LAF ❤";
					$headers = 'Lost And Found oksjon';
					setEmailSent($auctionID);
					
					mail($email, $headers, $message);
					$notice = "success";	
				}
			}
		}

		$stmt->close();
        $conn->close();
        return $notice;
	}
	function setEmailSent($id){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("UPDATE AUCTION SET winner_email_sent = 1 WHERE auction_ID = '{$id}'");
		echo $conn->error;

		$stmt->execute();
		if($stmt->execute()){
			$notice = "success";
		}else{
			$notice = 404;
		}
		
		$stmt->close();
        $conn->close();
        return $notice;
	}

	function setExpired($id){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("UPDATE AUCTION SET expired = 1 WHERE auction_id='{$id}'");
		echo $conn->error;
		if($stmt->execute()){
			$notice = "yay";
		}else{
			$notice = 404;
		}

		$stmt->close();
        $conn->close();
        return $notice;
	}
	
	function getWinnerEmail($id){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT email FROM OFFER WHERE AUCTION_auction_ID = '{$id}'");
		echo $conn->error;

		$stmt->bind_result($emailDB);
		$stmt->execute();

		if($stmt->fetch()){
			$notice = $emailDB;
		}else{
			$notice = 404;
		}

		$stmt->close();
        $conn->close();
        return $notice;
	}

	function selectStorage($id){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT storage_place_name FROM FOUND_ITEM_AD JOIN STORAGE_PLACE ON 
		FOUND_ITEM_AD.STORAGE_PLACE_storage_place_ID = STORAGE_PLACE.storage_place_ID WHERE found_item_ad_ID = '{$id}'");
		echo $conn->error;

		$stmt->bind_result($storageDB);
		$stmt->execute();

		if($stmt->fetch()){
			$notice = $storageDB;
		}else{
			$notice = 404;
		}

		$stmt->close();
        $conn->close();
        return $notice;
	}

	function selectDescription($id){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT description FROM FOUND_ITEM_AD WHERE found_item_ad_ID = '{$id}'");
		echo $conn->error;

		$stmt->bind_result($descriptionDB);
		$stmt->execute();

		if($stmt->fetch()){
			$notice = $descriptionDB;
		}else{
			$notice = 404;
		}
		
		$stmt->close();
        $conn->close();
        return $notice;
	}
	
	
?>