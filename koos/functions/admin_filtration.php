<?php 
    function displayLostItemsAdmin($offset,$searchedName,$searchedCategory,$searchedArea,$thisLink){
        $monthsET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
        $notice = null;
        $page = 'lost.php';
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        if($searchedName==null&&$searchedArea==null&&$searchedCategory==null){
            $stmt = $conn->prepare("SELECT lost_post_ID, description, picture, lost_place, DATE_FORMAT(lost_date, '%d'), DATE_FORMAT(lost_date, '%c'), DATE_FORMAT(lost_date, '%Y') 
            FROM LOST_ITEM_AD WHERE expired = 0 AND deleted = 0 ORDER BY lost_post_ID DESC LIMIT 3 OFFSET ?");
            
        }else if($searchedName!=null&&$searchedArea==null&&$searchedCategory==null){
            $stmt = $conn->prepare("SELECT lost_post_ID, description, picture, lost_place, DATE_FORMAT(lost_date, '%d'), DATE_FORMAT(lost_date, '%c'), DATE_FORMAT(lost_date, '%Y') 
            FROM LOST_ITEM_AD WHERE expired = 0 AND description LIKE'%{$searchedName}%' AND deleted = 0 ORDER BY lost_post_ID DESC LIMIT 3 OFFSET ?");
        }else if($searchedName==null&&$searchedArea!=null&&$searchedCategory==null){
            $stmt = $conn->prepare("SELECT lost_post_ID, description, picture, lost_place, DATE_FORMAT(lost_date, '%d'), DATE_FORMAT(lost_date, '%c'), DATE_FORMAT(lost_date, '%Y') 
            FROM LOST_ITEM_AD WHERE expired = 0 AND deleted = 0  AND lost_place LIKE '%{$searchedArea}%' ORDER BY lost_post_ID DESC LIMIT 3 OFFSET ?");
        }else if($searchedName==null&&$searchedArea==null&&$searchedCategory!=null){
            $stmt = $conn->prepare("SELECT lost_post_ID, description, picture, lost_place, DATE_FORMAT(lost_date, '%d'), DATE_FORMAT(lost_date, '%c'), DATE_FORMAT(lost_date, '%Y') 
            FROM LOST_ITEM_AD WHERE expired = 0 AND description LIKE'%{$searchedName}%' AND CATEGORY_category_ID='{$searchedCategory}' AND deleted = 0 ORDER BY lost_post_ID DESC LIMIT 3 OFFSET ?");
            
        }else if($searchedName!=null&&$searchedArea!=null&&$searchedCategory==null){
            $stmt = $conn->prepare("SELECT lost_post_ID, description, picture, lost_place, DATE_FORMAT(lost_date, '%d'), DATE_FORMAT(lost_date, '%c'), DATE_FORMAT(lost_date, '%Y') 
            FROM LOST_ITEM_AD WHERE expired = 0 AND CATEGORY_category_ID='{$searchedCategory}' AND lost_place LIKE '%{$searchedArea}%' AND description LIKE'%{$searchedName}%'   AND deleted = 0 ORDER BY lost_post_ID DESC LIMIT 3 OFFSET ?");
        }else if($searchedName==null&&$searchedArea!=null&&$searchedCategory!=null){
            $stmt = $conn->prepare("SELECT lost_post_ID, description, picture, lost_place, DATE_FORMAT(lost_date, '%d'), DATE_FORMAT(lost_date, '%c'), DATE_FORMAT(lost_date, '%Y') 
            FROM LOST_ITEM_AD WHERE expired = 0 AND lost_place LIKE '%{$searchedArea}%' AND CATEGORY_category_ID='{$searchedCategory}' AND deleted = 0 ORDER BY lost_post_ID DESC LIMIT 3 OFFSET ?");
            
        }else if($searchedName!=null&&$searchedArea==null&&$searchedCategory!=null){
            $stmt = $conn->prepare("SELECT lost_post_ID, description, picture, lost_place, DATE_FORMAT(lost_date, '%d'), DATE_FORMAT(lost_date, '%c'), DATE_FORMAT(lost_date, '%Y') 
            FROM LOST_ITEM_AD WHERE expired = 0 AND description LIKE'%{$searchedName}%' AND CATEGORY_category_ID='{$searchedCategory}' AND deleted = 0 ORDER BY lost_post_ID DESC LIMIT 3 OFFSET ?");
            
        }else if($searchedName!=null&&$searchedArea!=null&&$searchedCategory!=null){
            $stmt = $conn->prepare("SELECT lost_post_ID, description, picture, lost_place, DATE_FORMAT(lost_date, '%d'), DATE_FORMAT(lost_date, '%c'), DATE_FORMAT(lost_date, '%Y') 
            FROM LOST_ITEM_AD WHERE expired = 0 AND description LIKE'%{$searchedName}%' AND lost_place LIKE '%{$searchedArea}%' AND CATEGORY_category_ID='{$searchedCategory}' AND deleted = 0 ORDER BY lost_post_ID DESC LIMIT 3 OFFSET ?");
            
        }
        
        $stmt->bind_param("i", $offset);
        echo $conn->error;
        $stmt->bind_result($id, $description, $pic, $place, $day, $month, $year);
        $stmt->execute();
            
            while($stmt->fetch()){
                if($pic=="puudub"){
                    if($place == null){
                        $place = "Kaotamise koha kohta info puudub!";
                    }
                    $notice .= ' <div class="product">';
                    $notice .= '<a class="productImageBox" href="admin_view_ad.php?id=' .$id .'"><img class="productImage" src="' .$GLOBALS["pic_read_dir_thumb"] .$pic .'"></a>';
                    $notice .= '<div class="productDesc">';
                    $notice .= '<p> Kirjeldus: ' .$description .'</p>';
                    $notice .= '<p>Kaotamise koht: ' .$place .'</p>';
                    $notice .= '<p> Kaotamise kuupäev: ' .$day .'.' .$monthsET[$month-1] .' ' .$year .'</p>';
                    $notice .= '<p class="text">E-mail: '. $email .'</p>';
                    $notice .= '<form method="POST" action="#"><input type ="hidden" value="' .$id .'" name="idInput">';
                    $notice .= '<input type="submit" id="delete" name="deleteLostAd" value="KUSTUTA"></form>';
                    $notice .= '</div></div>';
                }else{
                    if($place == null){
                        $place = "Kaotamise koha kohta info puudub!";
                    }
                    $notice .= ' <div class="product">';
                    $notice .= '<a class="productImageBox" href="admin_view_ad.php?id=' .$id .'"><img class="productImage" src="' .$GLOBALS["pic_read_dir_thumb"] .$pic .'"></a>';
                    $notice .= '<div class="productDesc">';
                    $notice .= '<p> Kirjeldus: ' .$description .'</p>';
                    $notice .= '<p>Kaotamise koht: ' .$place .'</p>';
                    $notice .= '<p> Kaotamise kuupäev: ' .$day .'.' .$monthsET[$month-1] .' ' .$year .'</p>';
                    $notice .= '<form method="POST" action="#"><input type ="hidden" value="' .$id .'" name="idInput">';
                    $notice .= '<input type="submit" id="delete" name="deleteLostAd" value="KUSTUTA"></form>';
                    $notice .= '</div></div>';
                }
            }
            if($notice == null){
                //$notice .= '<p class="flex-row">Hetkel esemeid pole!</p>';
                $notice = 100; // no more items;
            }
            
            $stmt->close();
            $conn->close();
            return $notice;
        
        
    }
    function selectFoundPostsAdmin($offset,$searchedName,$searchedCategory,$searchedStorage,$searchedArea,$thisLink) {
        $response = null;
        $monthsET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
        $page = 'found.php';
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        if($searchedName==null&&$searchedArea==null&&$searchedCategory==null&&$searchedStorage==null){
        $stmt = $conn->prepare("SELECT found_item_ad_ID, description,DATE_FORMAT(found_date, '%d'), DATE_FORMAT(found_date, '%c'), DATE_FORMAT(found_date, '%Y'),picture,CATEGORY_category_ID,place_found, storage_place_name
        FROM FOUND_ITEM_AD JOIN STORAGE_PLACE ON FOUND_ITEM_AD.STORAGE_PLACE_storage_place_ID = STORAGE_PLACE.storage_place_ID WHERE expired=0  AND deleted = 0 ORDER BY found_item_ad_ID DESC LIMIT 3 OFFSET ?");
        }
        else if($searchedName!=null&&$searchedArea==null&&$searchedCategory==null&&$searchedStorage==null){
        $stmt = $conn->prepare("SELECT found_item_ad_ID, description,DATE_FORMAT(found_date, '%d'), DATE_FORMAT(found_date, '%c'), DATE_FORMAT(found_date, '%Y'),picture,CATEGORY_category_ID,place_found, storage_place_name
        FROM FOUND_ITEM_AD JOIN STORAGE_PLACE ON FOUND_ITEM_AD.STORAGE_PLACE_storage_place_ID = STORAGE_PLACE.storage_place_ID WHERE expired=0 AND description LIKE '%{$searchedName}%' AND deleted = 0 ORDER BY found_item_ad_ID DESC LIMIT 3 OFFSET ?");
        
        }elseif($searchedName==null&&$searchedArea!=null&&$searchedCategory==null&&$searchedStorage==null){
        $stmt = $conn->prepare("SELECT found_item_ad_ID, description,DATE_FORMAT(found_date, '%d'), DATE_FORMAT(found_date, '%c'), DATE_FORMAT(found_date, '%Y'),picture,CATEGORY_category_ID,place_found, storage_place_name
        FROM FOUND_ITEM_AD JOIN STORAGE_PLACE ON FOUND_ITEM_AD.STORAGE_PLACE_storage_place_ID = STORAGE_PLACE.storage_place_ID WHERE expired=0 AND place_found LIKE '%{$searchedArea}%' AND deleted = 0 ORDER BY found_item_ad_ID DESC LIMIT 3 OFFSET ?");
        
        }elseif($searchedName==null&&$searchedArea==null&&$searchedCategory!=null&&$searchedStorage==null){
        $stmt = $conn->prepare("SELECT found_item_ad_ID, description,DATE_FORMAT(found_date, '%d'), DATE_FORMAT(found_date, '%c'), DATE_FORMAT(found_date, '%Y'),picture,CATEGORY_category_ID,place_found, storage_place_name
        FROM FOUND_ITEM_AD JOIN STORAGE_PLACE ON FOUND_ITEM_AD.STORAGE_PLACE_storage_place_ID = STORAGE_PLACE.storage_place_ID WHERE expired=0 AND  CATEGORY_category_ID LIKE '{$searchedCategory}' AND deleted = 0 ORDER BY found_item_ad_ID DESC LIMIT 3 OFFSET ?");
       
        }elseif($searchedName!=null&&$searchedArea!=null&&$searchedCategory==null&&$searchedStorage==null){
        $stmt = $conn->prepare("SELECT found_item_ad_ID, description,DATE_FORMAT(found_date, '%d'), DATE_FORMAT(found_date, '%c'), DATE_FORMAT(found_date, '%Y'),picture,CATEGORY_category_ID,place_found, storage_place_name
        FROM FOUND_ITEM_AD JOIN STORAGE_PLACE ON FOUND_ITEM_AD.STORAGE_PLACE_storage_place_ID = STORAGE_PLACE.storage_place_ID WHERE expired=0 AND place_found LIKE '%{$searchedArea}%' AND description LIKE '%{$searchedName}%' AND deleted = 0 ORDER BY found_item_ad_ID DESC LIMIT 3 OFFSET ?");
        
        }elseif($searchedName!=null&&$searchedArea==null&&$searchedCategory!=null&&$searchedStorage==null){
        $stmt = $conn->prepare("SELECT found_item_ad_ID, description,DATE_FORMAT(found_date, '%d'), DATE_FORMAT(found_date, '%c'), DATE_FORMAT(found_date, '%Y'),picture,CATEGORY_category_ID,place_found, storage_place_name
        FROM FOUND_ITEM_AD JOIN STORAGE_PLACE ON FOUND_ITEM_AD.STORAGE_PLACE_storage_place_ID = STORAGE_PLACE.storage_place_ID WHERE expired=0 AND description LIKE '%{$searchedName}%' AND CATEGORY_category_ID LIKE '{$searchedCategory}' AND deleted = 0 ORDER BY found_item_ad_ID DESC LIMIT 3 OFFSET ?");
        
        }elseif($searchedName==null&&$searchedArea!=null&&$searchedCategory!=null&&$searchedStorage==null){
        $stmt = $conn->prepare("SELECT found_item_ad_ID, description,DATE_FORMAT(found_date, '%d'), DATE_FORMAT(found_date, '%c'), DATE_FORMAT(found_date, '%Y'),picture,CATEGORY_category_ID,place_found, storage_place_name
        FROM FOUND_ITEM_AD JOIN STORAGE_PLACE ON FOUND_ITEM_AD.STORAGE_PLACE_storage_place_ID = STORAGE_PLACE.storage_place_ID WHERE expired=0 AND place_found LIKE '%{$searchedArea}%' AND CATEGORY_category_ID LIKE '{$searchedCategory}' AND deleted = 0 ORDER BY found_item_ad_ID DESC LIMIT 3 OFFSET ?");
        
        }elseif($searchedName!=null&&$searchedArea!=null&&$searchedCategory!=null&&$searchedStorage==null){
        $stmt = $conn->prepare("SELECT found_item_ad_ID, description,DATE_FORMAT(found_date, '%d'), DATE_FORMAT(found_date, '%c'), DATE_FORMAT(found_date, '%Y'),picture,CATEGORY_category_ID,place_found, storage_place_name
        FROM FOUND_ITEM_AD JOIN STORAGE_PLACE ON FOUND_ITEM_AD.STORAGE_PLACE_storage_place_ID = STORAGE_PLACE.storage_place_ID WHERE expired=0 AND place_found LIKE '%{$searchedArea}%' AND description LIKE '%{$searchedName}%' AND CATEGORY_category_ID LIKE '{$searchedCategory}' AND deleted = 0 ORDER BY found_item_ad_ID DESC LIMIT 3 OFFSET ?");
        /////////////////////////////////////////////////////////TINGIMUSED KOOS SEARCHED STORAGEGA
        }elseif($searchedName==null&&$searchedArea==null&&$searchedCategory==null&&$searchedStorage!=null){
        $stmt = $conn->prepare("SELECT found_item_ad_ID, description,DATE_FORMAT(found_date, '%d'), DATE_FORMAT(found_date, '%c'), DATE_FORMAT(found_date, '%Y'),picture,CATEGORY_category_ID,place_found, storage_place_name
        FROM FOUND_ITEM_AD JOIN STORAGE_PLACE ON FOUND_ITEM_AD.STORAGE_PLACE_storage_place_ID = STORAGE_PLACE.storage_place_ID WHERE expired=0 AND STORAGE_PLACE_storage_place_ID LIKE '%{$searchedStorage}%'AND deleted = 0 ORDER BY found_item_ad_ID DESC LIMIT 3 OFFSET ?");
        }elseif($searchedName==null&&$searchedArea==null&&$searchedCategory!=null&&$searchedStorage!=null){
        $stmt = $conn->prepare("SELECT found_item_ad_ID, description,DATE_FORMAT(found_date, '%d'), DATE_FORMAT(found_date, '%c'), DATE_FORMAT(found_date, '%Y'),picture,CATEGORY_category_ID,place_found, storage_place_name
        FROM FOUND_ITEM_AD JOIN STORAGE_PLACE ON FOUND_ITEM_AD.STORAGE_PLACE_storage_place_ID = STORAGE_PLACE.storage_place_ID WHERE expired=0 AND  STORAGE_PLACE_storage_place_ID LIKE '%{$searchedStorage}%' AND CATEGORY_category_ID LIKE '{$searchedCategory}' AND deleted = 0 ORDER BY found_item_ad_ID DESC LIMIT 3 OFFSET ?");
        }elseif($searchedName==null&&$searchedArea!=null&&$searchedCategory==null&&$searchedStorage!=null){
        $stmt = $conn->prepare("SELECT found_item_ad_ID, description,DATE_FORMAT(found_date, '%d'), DATE_FORMAT(found_date, '%c'), DATE_FORMAT(found_date, '%Y'),picture,CATEGORY_category_ID,place_found, storage_place_name
        FROM FOUND_ITEM_AD JOIN STORAGE_PLACE ON FOUND_ITEM_AD.STORAGE_PLACE_storage_place_ID = STORAGE_PLACE.storage_place_ID WHERE expired=0 AND place_found LIKE '%{$searchedArea}%' AND STORAGE_PLACE_storage_place_ID LIKE '%{$searchedStorage}%' AND deleted = 0 ORDER BY found_item_ad_ID DESC LIMIT 3 OFFSET ?");
        }elseif($searchedName!=null&&$searchedArea==null&&$searchedCategory==null&&$searchedStorage!=null){
        $stmt = $conn->prepare("SELECT found_item_ad_ID, description,DATE_FORMAT(found_date, '%d'), DATE_FORMAT(found_date, '%c'), DATE_FORMAT(found_date, '%Y'),picture,CATEGORY_category_ID,place_found, storage_place_name
        FROM FOUND_ITEM_AD JOIN STORAGE_PLACE ON FOUND_ITEM_AD.STORAGE_PLACE_storage_place_ID = STORAGE_PLACE.storage_place_ID WHERE expired=0 AND STORAGE_PLACE_storage_place_ID LIKE '%{$searchedStorage}%' description LIKE '%{$searchedName}%'  AND deleted = 0 ORDER BY found_item_ad_ID DESC LIMIT 3 OFFSET ?");
        }elseif($searchedName!=null&&$searchedArea!=null&&$searchedCategory==null&&$searchedStorage!=null){
        $stmt = $conn->prepare("SELECT found_item_ad_ID, description,DATE_FORMAT(found_date, '%d'), DATE_FORMAT(found_date, '%c'), DATE_FORMAT(found_date, '%Y'),picture,CATEGORY_category_ID,place_found, storage_place_name
        FROM FOUND_ITEM_AD JOIN STORAGE_PLACE ON FOUND_ITEM_AD.STORAGE_PLACE_storage_place_ID = STORAGE_PLACE.storage_place_ID WHERE expired=0 AND place_found LIKE '%{$searchedArea}%' AND description LIKE '%{$searchedName}%' AND STORAGE_PLACE_storage_place_ID LIKE '%{$searchedStorage}%' AND deleted = 0 ORDER BY found_item_ad_ID DESC LIMIT 3 OFFSET ?");
        }elseif($searchedName!=null&&$searchedArea==null&&$searchedCategory!=null&&$searchedStorage!=null){
        $stmt = $conn->prepare("SELECT found_item_ad_ID, description,DATE_FORMAT(found_date, '%d'), DATE_FORMAT(found_date, '%c'), DATE_FORMAT(found_date, '%Y'),picture,CATEGORY_category_ID,place_found, storage_place_name
        FROM FOUND_ITEM_AD JOIN STORAGE_PLACE ON FOUND_ITEM_AD.STORAGE_PLACE_storage_place_ID = STORAGE_PLACE.storage_place_ID WHERE expired=0 AND STORAGE_PLACE_storage_place_ID LIKE '%{$searchedStorage}%' AND description LIKE '%{$searchedName}%' AND CATEGORY_category_ID LIKE '{$searchedCategory}' AND deleted = 0 ORDER BY found_item_ad_ID DESC LIMIT 3 OFFSET ?");
        }elseif($searchedName==null&&$searchedArea!=null&&$searchedCategory!=null&&$searchedStorage!=null){
        $stmt = $conn->prepare("SELECT found_item_ad_ID, description,DATE_FORMAT(found_date, '%d'), DATE_FORMAT(found_date, '%c'), DATE_FORMAT(found_date, '%Y'),picture,CATEGORY_category_ID,place_found, storage_place_name
        FROM FOUND_ITEM_AD JOIN STORAGE_PLACE ON FOUND_ITEM_AD.STORAGE_PLACE_storage_place_ID = STORAGE_PLACE.storage_place_ID WHERE expired=0 AND place_found LIKE '%{$searchedArea}%' AND STORAGE_PLACE_storage_place_ID LIKE '%{$searchedStorage}%' AND CATEGORY_category_ID LIKE '{$searchedCategory}' AND deleted = 0 ORDER BY found_item_ad_ID DESC LIMIT 3 OFFSET ?");
        }elseif($searchedName!=null&&$searchedArea!=null&&$searchedCategory!=null&&$searchedStorage!=null){
        $stmt = $conn->prepare("SELECT found_item_ad_ID, description,DATE_FORMAT(found_date, '%d'), DATE_FORMAT(found_date, '%c'), DATE_FORMAT(found_date, '%Y'),picture,CATEGORY_category_ID,place_found, storage_place_name
        FROM FOUND_ITEM_AD JOIN STORAGE_PLACE ON FOUND_ITEM_AD.STORAGE_PLACE_storage_place_ID = STORAGE_PLACE.storage_place_ID WHERE expired=0 AND place_found LIKE '%{$searchedArea}%' AND description LIKE '%{$searchedName}%' AND CATEGORY_category_ID LIKE '{$searchedCategory}' AND STORAGE_PLACE_storage_place_ID LIKE '%{$searchedStorage}%' AND deleted = 0 ORDER BY found_item_ad_ID DESC LIMIT 3 OFFSET ?");
        }
        $stmt->bind_param("i", $offset);
        echo $conn->error;
        $stmt->bind_result($id, $description, $day, $month, $year, $picture, $CATEGORY_category_ID, $place_found, $storage);
        $stmt->execute();
        while($stmt->fetch()){
            $response .= ' <div class="product flex-row">';
            $response .= '<img class="productImageBox" src="' .$GLOBALS["pic_read_dir_thumb"] . $picture  .'"></a>';
            $response .= '<div class="flex-column productDesc">';
            $response .= '<p>Kirjeldus: ' . $description . '</p>';
            $response .= '<p>Leidmise koht:' . $place_found . '</p>';
            $response .= '<p>Kuupäev: ' .$day .'.' .$monthsET[$month-1] .' ' .$year .'</p>';
            $response .= '<p>Hoiupaik: ' . $storage . '</p>';
            $response .= '<p>Hoiupaik: ' . $storage . '</p>';
            $response .= '<form method="POST" action="#"><input type ="hidden" value="' .$id .'" name="idInput">';
            $response .= '<input type="submit" id="delete" name="deleteAd" value="KUSTUTA"></form>';
            $response .= '</div><div class="aside"></div></div>';
        }
        if($response == null){
            $response = 100; // no more items error code
        }
        $response .= "\n";

        $stmt->close();
        $conn->close();
        return $response;
    }

    function getSuccessfulAuctions($searchedName,$searchedCategory,$searchedArea,$thisLink, $offset){
        $notice = null;
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        $sqlStatementMain="SELECT found_item_ad_ID, description, picture, storage_place_name FROM FOUND_ITEM_AD JOIN STORAGE_PLACE ON 
        FOUND_ITEM_AD.STORAGE_PLACE_storage_place_ID = STORAGE_PLACE.storage_place_ID WHERE expired = 1 AND auctioned = 1 AND deleted = 0 ";
        $sqlStatementCondition="";
        if($searchedName==null&&$searchedArea==null&&$searchedCategory==null){
            $sqlStatementCondition="";
        }else if($searchedName!=null&&$searchedArea==null&&$searchedCategory==null){

            $sqlStatementCondition=" AND description LIKE '%{$searchedName}%' ";

        }else if($searchedName==null&&$searchedArea!=null&&$searchedCategory==null){
            
            $sqlStatementCondition=" AND place_found LIKE '%{$searchedArea}%' ";

        }else if($searchedName==null&&$searchedArea==null&&$searchedCategory!=null){
            $sqlStatementCondition=" 0 AND CATEGORY_category_ID LIKE '%{$searchedCategory}%' ";

        }else if($searchedName!=null&&$searchedArea!=null&&$searchedCategory==null){
            $sqlStatementCondition=" AND description LIKE '%{$searchedName}%'AND place_found LIKE '%{$searchedArea}%' ";

        }else if($searchedName!=null&&$searchedArea==null&&$searchedCategory!=null){
            $sqlStatementCondition=" AND description LIKE '%{$searchedName}%'AND  CATEGORY_category_ID LIKE '%{$searchedCategory}%'  ";

        }else if($searchedName==null&&$searchedArea!=null&&$searchedCategory!=null){
            $sqlStatementCondition=" AND  place_found LIKE '%{$searchedArea}%' AND CATEGORY_category_ID LIKE '%{$searchedCategory}%' ";
        
        }else if($searchedName!=null&&$searchedArea!=null&&$searchedCategory!=null){
            $sqlStatementCondition=" AND description LIKE '%{$searchedName}%'AND place_found LIKE '%{$searchedArea}%' AND CATEGORY_category_ID LIKE '%{$searchedCategory}%' ";
        }
        $sqlStatementMain.=$sqlStatementCondition;
        $stmt=$conn->prepare($sqlStatementMain);
        echo $searchedCategory;
        echo $searchedArea;
        echo $conn->error;
        $stmt->bind_result($id, $description, $pic, $storage_place);
        $stmt->execute();
        
        while($stmt->fetch()){
            $isAuctionExpired = checkIfExpiredAuction($id);
            $auctionID = getAuctionIDAdmin($id);
            if($isAuctionExpired == 1){
                $email = getBidEmail($auctionID);
                if($email != "lostandfound@tlu.ee"){
                    $bestOffer = getHighestBid($auctionID);
                    $notice .= ' <div class="product flex-row" >';
                    $notice .= '<img class="productImageBox" src="' .$GLOBALS["pic_read_dir_thumb"] .$pic .'">';
                    $notice .= '<div class="productDesc">';
                    $notice .= '<p class="text">Kirjeldus: ' .$description .'</p>';
                    $notice .= '<p class="text">Hoiupaik: ' .$storage_place .'</p>';
                    $notice .= '<p class="text">E-mail: ' .$email .'</p>';
                    $notice .= '<p class="text">Parim pakkumine: ' .$bestOffer .' €</p>';
                    $notice .= '</div></div>';
                }
            }
        }
        

        $stmt->close();
		$conn->close();
		return $notice;
    }



    function getExpiredAuctions($searchedName,$searchedCategory,$searchedStorage,$thisLink, $offset){
        $notice = null;
        
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]); 
        if($searchedName==null&&$searchedStorage==null&&$searchedCategory==null){
            $stmt = $conn->prepare("SELECT found_item_ad_ID, description, picture, storage_place_name FROM FOUND_ITEM_AD JOIN STORAGE_PLACE ON 
        FOUND_ITEM_AD.STORAGE_PLACE_storage_place_ID = STORAGE_PLACE.storage_place_ID WHERE expired = 1 AND auctioned = 1 AND deleted = 0  ORDER BY found_item_ad_ID DESC");

        }else if($searchedName!=null&&$searchedStorage==null&&$searchedCategory==null){
            $stmt = $conn->prepare("SELECT found_item_ad_ID, description, picture, storage_place_name FROM FOUND_ITEM_AD JOIN STORAGE_PLACE ON 
            FOUND_ITEM_AD.STORAGE_PLACE_storage_place_ID = STORAGE_PLACE.storage_place_ID WHERE expired = 1 AND auctioned = 1 AND deleted = 0 AND description LIKE '%{$searchedName}%' ORDER BY found_item_ad_ID DESC");

        }else if($searchedName==null&&$searchedStorage!=null&&$searchedCategory==null){
            $stmt = $conn->prepare("SELECT found_item_ad_ID, description, picture, storage_place_name FROM FOUND_ITEM_AD JOIN STORAGE_PLACE ON 
            FOUND_ITEM_AD.STORAGE_PLACE_storage_place_ID = STORAGE_PLACE.storage_place_ID WHERE expired = 1 AND auctioned = 1 AND deleted = 0 AND STORAGE_PLACE_storage_place_ID LIKE '%{$searchedStorage}%'   ORDER BY found_item_ad_ID DESC");

        }else if($searchedName==null&&$searchedStorage==null&&$searchedCategory!=null){
            $stmt = $conn->prepare("SELECT found_item_ad_ID, description, picture, storage_place_name FROM FOUND_ITEM_AD JOIN STORAGE_PLACE ON 
            FOUND_ITEM_AD.STORAGE_PLACE_storage_place_ID = STORAGE_PLACE.storage_place_ID WHERE expired = 1 AND auctioned = 1 AND deleted = 0 AND CATEGORY_category_ID LIKE '%{$searchedCategory}%'  ORDER BY found_item_ad_ID DESC");

        }else if($searchedName!=null&&$searchedStorage!=null&&$searchedCategory==null){
            $stmt = $conn->prepare("SELECT found_item_ad_ID, description, picture, storage_place_name FROM FOUND_ITEM_AD JOIN STORAGE_PLACE ON 
            FOUND_ITEM_AD.STORAGE_PLACE_storage_place_ID = STORAGE_PLACE.storage_place_ID WHERE expired = 1 AND auctioned = 1 AND deleted = 0 AND description LIKE '%{$searchedName}%'AND STORAGE_PLACE_storage_place_ID LIKE '%{$searchedStorage}%' ORDER BY found_item_ad_ID DESC");

        }else if($searchedName==null&&$searchedStorage!=null&&$searchedCategory!=null){
            $stmt = $conn->prepare("SELECT found_item_ad_ID, description, picture, storage_place_name FROM FOUND_ITEM_AD JOIN STORAGE_PLACE ON 
            FOUND_ITEM_AD.STORAGE_PLACE_storage_place_ID = STORAGE_PLACE.storage_place_ID WHERE expired = 1 AND auctioned = 1 AND deleted = 0 AND STORAGE_PLACE_storage_place_ID LIKE '%{$searchedStorage}%' AND CATEGORY_category_ID LIKE '%{$searchedCategory}%'  ORDER BY found_item_ad_ID DESC");

        }else if($searchedName!=null&&$searchedStorage==null&&$searchedCategory!=null){
            $stmt = $conn->prepare("SELECT found_item_ad_ID, description, picture, storage_place_name FROM FOUND_ITEM_AD JOIN STORAGE_PLACE ON 
            FOUND_ITEM_AD.STORAGE_PLACE_storage_place_ID = STORAGE_PLACE.storage_place_ID WHERE expired = 1 AND auctioned = 1 AND deleted = 0 AND description LIKE '%{$searchedName}%' AND CATEGORY_category_ID LIKE '%{$searchedCategory}%'  ORDER BY found_item_ad_ID DESC");

        }else if($searchedName!=null&&$searchedStorage!=null&&$searchedCategory!=null){
            $stmt = $conn->prepare("SELECT found_item_ad_ID, description, picture, storage_place_name FROM FOUND_ITEM_AD JOIN STORAGE_PLACE ON 
            FOUND_ITEM_AD.STORAGE_PLACE_storage_place_ID = STORAGE_PLACE.storage_place_ID WHERE expired = 1 AND auctioned = 1 AND deleted = 0 AND description LIKE '%{$searchedName}%'AND STORAGE_PLACE_storage_place_ID LIKE '%{$searchedStorage}%' AND CATEGORY_category_ID LIKE '%{$searchedCategory}%'  ORDER BY found_item_ad_ID DESC");

        }
        echo $conn->error;
        $stmt->bind_result($id, $description, $pic, $storage_place);
        $stmt->execute();

        while($stmt->fetch()){
            $isAuctionExpired = checkIfExpiredAuction($id);
            $auctionID = getAuctionIDAdmin($id);
            if($isAuctionExpired == 1){
                $email = getBidEmail($auctionID);
                if($email == "lostandfound@tlu.ee"){
                    $bestOffer = getHighestBid($auctionID);
                    $notice .= ' <div class="product flex-row" >';
                    $notice .= '<img class="productImageBox" src="' .$GLOBALS["pic_read_dir_thumb"] .$pic .'">';
                    $notice .= '<div class="productDesc">';
                    $notice .= '<p class="text">Kirjeldus: ' .$description .'</p>';
                    $notice .= '<p class="text">Hoiupaik: ' .$storage_place .'</p>';
                    $notice .= '<form method="POST" action="#"><input type ="hidden" value="' .$id .'" name="idInput">';
                    $notice .= '<input type="submit" id="delete" name="deleteAd" value="KUSTUTA"></form>';
                    $notice .= '</div></div>';
                }
            }
        }

        $stmt->close();
		$conn->close();
		return $notice;
    }

    function counterOfStorages(){
        $storageHTML = null;
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("SELECT storage_place_ID, storage_place_name FROM STORAGE_PLACE");
        $stmt->bind_result($id, $storage_name);
        $stmt->execute();
        $array=array();
        while($stmt->fetch()){
            array_push($array,$storage_name);

        }
        $stmt->close();
	    $conn->close();
	    return $array;
    }
    function storageToID($storageName){
        $storageID = null;
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("SELECT storage_place_ID  FROM STORAGE_PLACE WHERE storage_place_name='{$storageName}'");
        $stmt->bind_result($id);
        $stmt->execute();
        while($stmt->fetch()){
            $storageID=$id;

        }
        $stmt->close();
	    $conn->close();
	    return $storageID;
    }

?>