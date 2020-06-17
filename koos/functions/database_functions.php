<?php
    // SANDRA
    function displayLostItems($offset,$searchedName,$searchedCategory,$searchedArea,$thisLink,$searchedStartDate,$searchedEndDate){
        $monthsET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
        $notice = null;
        $test=null;
        $page = 'lost.php';
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
                
        $sqlStatementMain="SELECT lost_post_ID, description, picture, lost_place, DATE_FORMAT(lost_date, '%d'), DATE_FORMAT(lost_date, '%c'), DATE_FORMAT(lost_date, '%Y'),lost_date
        FROM LOST_ITEM_AD WHERE expired = 0 AND deleted = 0 ";
        $sqlStatementCondition=null;

        $sqlAfterStatements=" ORDER BY lost_post_ID DESC LIMIT 3 OFFSET ?";
        if($searchedName==null&&$searchedArea==null&&$searchedCategory==null&&$searchedEndDate==null&&$searchedStartDate==null){
            $sqlStatementCondition="";
            
        }else if($searchedName!=null&&$searchedArea==null&&$searchedCategory==null&&$searchedStartDate==null&&$searchedEndDate==null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' ";
        }else if($searchedName==null&&$searchedArea!=null&&$searchedCategory==null&&$searchedStartDate==null&&$searchedEndDate==null){
            $sqlStatementCondition="  AND lost_place LIKE '%{$searchedArea}%' ";
        }else if($searchedName==null&&$searchedArea==null&&$searchedCategory!=null&&$searchedStartDate==null&&$searchedEndDate==null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND CATEGORY_category_ID='{$searchedCategory}' ";
            
        }else if($searchedName!=null&&$searchedArea!=null&&$searchedCategory==null&&$searchedStartDate==null&&$searchedEndDate==null){
            $sqlStatementCondition=" AND CATEGORY_category_ID='{$searchedCategory}' AND lost_place LIKE '%{$searchedArea}%' AND description LIKE'%{$searchedName}%'   ";
        }else if($searchedName==null&&$searchedArea!=null&&$searchedCategory!=null&&$searchedStartDate==null&&$searchedEndDate==null){
            $sqlStatementCondition=" AND lost_place LIKE '%{$searchedArea}%' AND CATEGORY_category_ID='{$searchedCategory}' ";
            
        }else if($searchedName!=null&&$searchedArea==null&&$searchedCategory!=null&&$searchedStartDate==null&&$searchedEndDate==null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND CATEGORY_category_ID='{$searchedCategory}'";
            
        }else if($searchedName!=null&&$searchedArea!=null&&$searchedCategory!=null&&$searchedStartDate==null&&$searchedEndDate==null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND lost_place LIKE '%{$searchedArea}%' AND CATEGORY_category_ID='{$searchedCategory}' ";// siit lisan kuupäeva tingimused start date
            
        }else if($searchedName==null&&$searchedArea==null&&$searchedCategory==null&&$searchedStartDate!=null&&$searchedEndDate==null){
            $sqlStatementCondition="AND lost_date>='$searchedStartDate' ";

            
        }else if($searchedName!=null&&$searchedArea==null&&$searchedCategory==null&&$searchedStartDate!=null&&$searchedEndDate==null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND lost_date>='$searchedStartDate'  ";
                
        }else if($searchedName==null&&$searchedArea!=null&&$searchedCategory==null&&$searchedStartDate!=null&&$searchedEndDate==null){
            $sqlStatementCondition=" AND lost_place LIKE '%{$searchedArea}%' AND lost_date>='$searchedStartDate'  ";
            
        }else if($searchedName==null&&$searchedArea==null&&$searchedCategory!=null&&$searchedStartDate!=null&&$searchedEndDate==null){
            $sqlStatementCondition=" AND CATEGORY_category_ID='{$searchedCategory}' AND lost_date>='$searchedStartDate'  ";
            
        }else if($searchedName!=null&&$searchedArea!=null&&$searchedCategory==null&&$searchedStartDate!=null&&$searchedEndDate==null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND lost_place LIKE '%{$searchedArea}%' AND lost_date>='$searchedStartDate'  ";
            
        }else if($searchedName==null&&$searchedArea!=null&&$searchedCategory!=null&&$searchedStartDate!=null&&$searchedEndDate==null){
            $sqlStatementCondition=" AND lost_place LIKE '%{$searchedArea}%' AND CATEGORY_category_ID='{$searchedCategory}' AND lost_date>='$searchedStartDate'  ";
            
        }else if($searchedName!=null&&$searchedArea==null&&$searchedCategory!=null&&$searchedStartDate!=null&&$searchedEndDate==null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND CATEGORY_category_ID='{$searchedCategory}' AND lost_date>='$searchedStartDate'  ";
            
        }else if($searchedName!=null&&$searchedArea!=null&&$searchedCategory!=null&&$searchedStartDate!=null&&$searchedEndDate==null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND lost_place LIKE '%{$searchedArea}%' AND CATEGORY_category_ID='{$searchedCategory}' AND lost_date>='$searchedStartDate'  ";

        
        
        }else if($searchedName==null&&$searchedArea==null&&$searchedCategory==null&&$searchedStartDate==null&&$searchedEndDate!=null){// siit end date
            $sqlStatementCondition="AND lost_date<='$searchedEndDate' ";

            
        }else if($searchedName!=null&&$searchedArea==null&&$searchedCategory==null&&$searchedStartDate==null&&$searchedEndDate!=null){ 
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND lost_date>='$searchedEndDate'  ";
                
        }else if($searchedName==null&&$searchedArea!=null&&$searchedCategory==null&&$searchedStartDate==null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND lost_place LIKE '%{$searchedArea}%' AND lost_date>='$searchedEndDate'  ";
            
        }else if($searchedName==null&&$searchedArea==null&&$searchedCategory!=null&&$searchedStartDate==null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND CATEGORY_category_ID='{$searchedCategory}' AND lost_date>='$searchedEndDate'  ";
            
        }else if($searchedName!=null&&$searchedArea!=null&&$searchedCategory==null&&$searchedStartDate==null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND lost_place LIKE '%{$searchedArea}%' AND lost_date>='$searchedEndDate'  ";
            
        }else if($searchedName==null&&$searchedArea!=null&&$searchedCategory!=null&&$searchedStartDate==null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND lost_place LIKE '%{$searchedArea}%' AND CATEGORY_category_ID='{$searchedCategory}' AND lost_date>='$searchedEndDate'  ";
            
        }else if($searchedName!=null&&$searchedArea==null&&$searchedCategory!=null&&$searchedStartDate==null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND CATEGORY_category_ID='{$searchedCategory}' AND lost_date>='$searchedEndDate'  ";
            
        }else if($searchedName!=null&&$searchedArea!=null&&$searchedCategory!=null&&$searchedStartDate==null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND lost_place LIKE '%{$searchedArea}%' AND CATEGORY_category_ID='{$searchedCategory}' AND lost_date>='$searchedEndDate'  ";
        
        }else if($searchedName==null&&$searchedArea==null&&$searchedCategory==null&&$searchedStartDate!=null&&$searchedEndDate!=null){ // end and start date
            $sqlStatementCondition="AND (lost_date BETWEEN '$searchedStartDate' AND '$searchedEndDate') ";

            
        }else if($searchedName!=null&&$searchedArea==null&&$searchedCategory==null&&$searchedStartDate!=null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND (lost_date BETWEEN '$searchedStartDate' AND '$searchedEndDate') ";
                
        }else if($searchedName==null&&$searchedArea!=null&&$searchedCategory==null&&$searchedStartDate!=null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND lost_place LIKE '%{$searchedArea}%' AND (lost_date BETWEEN '$searchedStartDate' AND '$searchedEndDate') ";
            
        }else if($searchedName==null&&$searchedArea==null&&$searchedCategory!=null&&$searchedStartDate!=null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND CATEGORY_category_ID='{$searchedCategory}' AND (lost_date BETWEEN '$searchedStartDate' AND '$searchedEndDate') ";
            
        }else if($searchedName!=null&&$searchedArea!=null&&$searchedCategory==null&&$searchedStartDate!=null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND lost_place LIKE '%{$searchedArea}%' AND (lost_date BETWEEN '$searchedStartDate' AND '$searchedEndDate') ";
            
        }else if($searchedName==null&&$searchedArea!=null&&$searchedCategory!=null&&$searchedStartDate!=null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND lost_place LIKE '%{$searchedArea}%' AND CATEGORY_category_ID='{$searchedCategory}' AND (lost_date BETWEEN '$searchedStartDate' AND '$searchedEndDate') ";
            
        }else if($searchedName!=null&&$searchedArea==null&&$searchedCategory!=null&&$searchedStartDate!=null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND CATEGORY_category_ID='{$searchedCategory}' AND (lost_date BETWEEN '$searchedStartDate' AND '$searchedEndDate') ";
            
        }else if($searchedName!=null&&$searchedArea!=null&&$searchedCategory!=null&&$searchedStartDate!=null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND lost_place LIKE '%{$searchedArea}%' AND CATEGORY_category_ID='{$searchedCategory}' AND (lost_date BETWEEN '$searchedStartDate' AND '$searchedEndDate') ";
        
        }
        
        $sqlStatementMain.=$sqlStatementCondition;
        $sqlStatementMain.=$sqlAfterStatements;
        $stmt=$conn->prepare($sqlStatementMain);
        echo $conn->error;
        $stmt->bind_param("i", $offset);
        echo $conn->error;
        $stmt->bind_result($id, $description, $pic, $place, $day, $month, $year,$date);
        $stmt->execute();
            
            while($stmt->fetch()){
                if($place == null){
                    $place = "Kaotamise koha kohta info puudub!";
                }
                $notice .= ' <div class="product">';
                $notice .= '<a class="productImageBox" href="view_ad.php?id=' .$id ."&page=" .$page .'">';
                if($pic == "puudub"){
                    $notice .= '<img class="productImage" src="../images/missing.png"' .'"></a>';
                }else{
                    $notice .= '<img class="productImage" src="' .$GLOBALS["pic_read_dir_thumb"] .$pic .'"></a>';
                }
                $notice .= '<div class="productDesc">';
                $notice .= '<p> Kirjeldus: ' .$description .'</p>';
                $notice .= '<p> Kaotamise koht: ' .$place .'</p>';
                $notice .= '<p> Kaotamise kuupäev: ' .$day .'.' .$monthsET[$month-1] .' ' .$year .'</p>';
                $notice .= '</div></div>';
            }


        if($notice == null){
            //$notice .= '<p class="flex-row">Hetkel esemeid pole!</p>';
            $notice = 100; // no more items;
        }
        
        $stmt->close();
        $conn->close();
        return $notice;
        
    }

    function viewObject($id, $page){
        $monthsET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
        $notice = null;
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        if($page=="lost.php"){
            $stmt = $conn->prepare("SELECT description, picture, lost_place, DATE_FORMAT(lost_date, '%d'), DATE_FORMAT(lost_date, '%c'), DATE_FORMAT(lost_date, '%Y'), email FROM LOST_ITEM_AD WHERE lost_post_ID='{$id}'");
            echo $conn->error;
            $stmt->bind_result($description, $pic, $place, $day, $month, $year, $email);
            $stmt->execute();
            while($stmt->fetch()){
                if($place == null){
                    $place = "Kaotamise koha kohta info puudub!";
                }
                $notice .= ' <div class="product flex-row" >';

                if($pic=="puudub"){
                    $notice .= '<img class="productImageBox" src="../images/missing.png">';
                }else{
                    $notice .= '<img class="productImageBox" src="' .$GLOBALS["pic_read_dir_thumb"] .$pic .'">';
                }
                
                $notice .= '<div class="productDesc">';
                $notice .= '<p class="text"> Kirjeldus: ' .$description .'</p>';
                $notice .= '<p class="text">Kaotamise koht: ' .$place .'</p>';
                $notice .= '<p class="text">Kaotamise kuupäev: ' .$day .'.' .$monthsET[$month-1] .' ' .$year .'</p>';
                $notice .= '<button id="delete">KUSTUTA</button>';
                $notice .= '<form id="deleteForm" method="POST"><div class="error-email smallerWidth"></div><input class ="inputBoxStyle" type="text" name="email" placeholder="E-mail">';
                $notice .= '<input class="deleteFormButton" type="submit" value="KUSTUTA" name="deleteAd"></form>';
                $notice .= '</div></div>';
                
            }
            $stmt->close();
            $conn->close();
            return $notice;
        }
        if($page=="found.php"){
            $stmt = $conn->prepare("SELECT description, picture, place_found, DATE_FORMAT(found_date, '%d'), DATE_FORMAT(found_date, '%c'), DATE_FORMAT(found_date, '%Y'), storage_place_name
            FROM FOUND_ITEM_AD JOIN STORAGE_PLACE ON FOUND_ITEM_AD.STORAGE_PLACE_storage_place_ID = STORAGE_PLACE.storage_place_ID WHERE found_item_ad_ID='{$id}'");
            
            echo $conn->error;
            $stmt->bind_result($description, $pic, $place, $day, $month, $year, $storage);
            $stmt->execute();
            while($stmt->fetch()){
                $notice .= ' <div class="product flex-row">';
                $notice .= '<img class="productImage" src="' .$GLOBALS["pic_read_dir_thumb"] .$pic .'">';
                $notice .= '<div class="flex-column productDesc">';
                $notice .= '<p>Kirjeldus: ' .$description .'</p>';
                $notice .= '<p>Leidmise koht: ' .$place .'</p>';
                $notice .= '<p>Leidmise kuupäev: ' .$day .'.' .$monthsET[$month-1] .' ' .$year .'</p>';
                $notice .= '<p>Hoiupaik: ' .$storage .'</p>';
                $notice .= '</div></div>';
            }
            $stmt->close();
            $conn->close();
            return $notice;
        }
    }

    function checkEmail($id, $email){
        $notice = null;
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("SELECT email FROM LOST_ITEM_AD WHERE lost_post_ID = ?");
        echo $conn->error;

        $stmt->bind_param("i", $id);
        $stmt->bind_result($emailFromDB);
        $stmt->execute();

        if($stmt->fetch()){
            if($email == $emailFromDB){
                $notice = 1;
            }else{
                $notice = 0;
            }
        }
        $stmt->close();
        $conn->close();
        return $notice;
    }

    function deleteAd($id){
        $response = null;
        $one = 1;
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("UPDATE LOST_ITEM_AD SET deleted = ? WHERE lost_post_ID = ?");
        echo $conn->error;
        $stmt->bind_param("ii", $one, $id);
        $stmt->execute();
        if($stmt->execute()){
            $response = 2;
        }else{
            $response = 404;
        }
        $stmt->close();
        $conn->close();
        return $response;
    }

    function lostExpired(){
        $notice = null;
        $one = 1;
        $zero = 0;
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("UPDATE LOST_ITEM_AD SET expired = ? WHERE DATEDIFF(NOW(), added_date) > 6 AND deleted = ?");

        echo $conn->error;
        $stmt->bind_param("ii", $one, $zero);
        $stmt->execute();

        if($stmt->execute()){
            $notice = null;
        }else{
            $notice = "Andmete uuendamisel tekkis tõrge!" .$stmt->error;
        }

        $stmt->close();
        $conn->close();
        return $notice;
    }

    function getFAQSection($id){
        $notice = null;
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("SELECT question, answer FROM FAQ JOIN SECTION ON FAQ.SECTION_section_ID = SECTION.section_ID WHERE section_ID ='{$id}'");
        echo $conn->error;
        $stmt->bind_result($question, $answer);
        $stmt->execute();
        while($stmt->fetch()){
            $notice .= '<h4>' .$question .'</h4>';
            $notice .= '<p>' .$answer .'</p>';
            $notice .= '<br>';
             
        }
        $stmt->close();
        $conn->close();
        return $notice;
    }


    // LIINA
    function insertFoundPost($storage, $found_date, $fileName, $category, $description, $placeFound) {
        $response = 1;
        $zero = 0;
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("INSERT INTO FOUND_ITEM_AD (found_date,place_found,picture,expired,description,CATEGORY_category_ID,deleted,STORAGE_PLACE_storage_place_ID, added_timestamp) VALUES(?,?,?,?,?,?,?,?,NOW())");
        echo $conn->error;
        $stmt->bind_param("sssisiii", $found_date, $placeFound, $fileName, $zero, $description, $category, $zero, $storage);
        if($stmt->execute()) {
            $response = 1;
        } else {
            $response = 404;
        }

        $stmt->close();
        $conn->close();
        return $response;
    }

    
    function selectFoundPostsHTML($offset,$searchedName,$searchedCategory,$searchedArea,$thisLink,$searchedStartDate,$searchedEndDate) {
        $response = null;
        $monthsET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
        $page = 'found.php';
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        
        $sqlStatementMain="SELECT found_item_ad_ID, description,DATE_FORMAT(found_date, '%d'), DATE_FORMAT(found_date, '%c'), DATE_FORMAT(found_date, '%Y'),picture,CATEGORY_category_ID,place_found, storage_place_name
        FROM FOUND_ITEM_AD JOIN STORAGE_PLACE ON FOUND_ITEM_AD.STORAGE_PLACE_storage_place_ID = STORAGE_PLACE.storage_place_ID WHERE expired=0  AND deleted = 0 ";
        $sqlStatementCondition=null;

        $sqlAfterStatements=" ORDER BY found_item_ad_ID DESC LIMIT 3 OFFSET ?";
        if($searchedName==null&&$searchedArea==null&&$searchedCategory==null&&$searchedStartDate==null&&$searchedEndDate==null){
            $sqlStatementCondition="";
        }else if($searchedName!=null&&$searchedArea==null&&$searchedCategory==null&&$searchedStartDate==null&&$searchedEndDate==null){
            $sqlStatementCondition=" AND description LIKE '%{$searchedName}%' ";
        
        }elseif($searchedName==null&&$searchedArea!=null&&$searchedCategory==null&&$searchedStartDate==null&&$searchedEndDate==null){
            $sqlStatementCondition=" AND place_found LIKE '%{$searchedArea}%' ";
        
        }elseif($searchedName==null&&$searchedArea==null&&$searchedCategory!=null&&$searchedStartDate==null&&$searchedEndDate==null){
            $sqlStatementCondition=" AND  CATEGORY_category_ID LIKE '{$searchedCategory}' ";
       
        }elseif($searchedName!=null&&$searchedArea!=null&&$searchedCategory==null&&$searchedStartDate==null&&$searchedEndDate==null){
            $sqlStatementCondition=" AND place_found LIKE '%{$searchedArea}%' AND description LIKE '%{$searchedName}%' ";
        
        }elseif($searchedName!=null&&$searchedArea==null&&$searchedCategory!=null&&$searchedStartDate==null&&$searchedEndDate==null){
            $sqlStatementCondition=" AND description LIKE '%{$searchedName}%' AND CATEGORY_category_ID LIKE '{$searchedCategory}' ";
        
        }elseif($searchedName==null&&$searchedArea!=null&&$searchedCategory!=null&&$searchedStartDate==null&&$searchedEndDate==null){
            $sqlStatementCondition=" AND place_found LIKE '%{$searchedArea}%' AND CATEGORY_category_ID LIKE '{$searchedCategory}' ";
        
        }elseif($searchedName!=null&&$searchedArea!=null&&$searchedCategory!=null&&$searchedStartDate==null&&$searchedEndDate==null){
            $sqlStatementCondition=" AND place_found LIKE '%{$searchedArea}%' AND description LIKE '%{$searchedName}%' AND CATEGORY_category_ID LIKE '{$searchedCategory}' ";
            
        }else if($searchedName==null&&$searchedArea==null&&$searchedCategory==null&&$searchedStartDate!=null&&$searchedEndDate==null){
            $sqlStatementCondition="AND found_date>='$searchedStartDate' ";

            
        }else if($searchedName!=null&&$searchedArea==null&&$searchedCategory==null&&$searchedStartDate!=null&&$searchedEndDate==null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND found_date>='$searchedStartDate'  ";
                
        }else if($searchedName==null&&$searchedArea!=null&&$searchedCategory==null&&$searchedStartDate!=null&&$searchedEndDate==null){
            $sqlStatementCondition=" AND place_found LIKE '%{$searchedArea}%' AND found_date>='$searchedStartDate'  ";
            
        }else if($searchedName==null&&$searchedArea==null&&$searchedCategory!=null&&$searchedStartDate!=null&&$searchedEndDate==null){
            $sqlStatementCondition=" AND CATEGORY_category_ID='{$searchedCategory}' AND found_date>='$searchedStartDate'  ";
            
        }else if($searchedName!=null&&$searchedArea!=null&&$searchedCategory==null&&$searchedStartDate!=null&&$searchedEndDate==null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND place_found LIKE '%{$searchedArea}%' AND found_date>='$searchedStartDate'  ";
            
        }else if($searchedName==null&&$searchedArea!=null&&$searchedCategory!=null&&$searchedStartDate!=null&&$searchedEndDate==null){
            $sqlStatementCondition=" AND place_found LIKE '%{$searchedArea}%' AND CATEGORY_category_ID='{$searchedCategory}' AND found_date>='$searchedStartDate'  ";
            
        }else if($searchedName!=null&&$searchedArea==null&&$searchedCategory!=null&&$searchedStartDate!=null&&$searchedEndDate==null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND CATEGORY_category_ID='{$searchedCategory}' AND found_date>='$searchedStartDate'  ";
            
        }else if($searchedName!=null&&$searchedArea!=null&&$searchedCategory!=null&&$searchedStartDate!=null&&$searchedEndDate==null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND place_found LIKE '%{$searchedArea}%' AND CATEGORY_category_ID='{$searchedCategory}' AND found_date>='$searchedStartDate'  ";

        
        
        }else if($searchedName==null&&$searchedArea==null&&$searchedCategory==null&&$searchedStartDate==null&&$searchedEndDate!=null){// siit end date
            $sqlStatementCondition="AND found_date<='$searchedEndDate' ";

            
        }else if($searchedName!=null&&$searchedArea==null&&$searchedCategory==null&&$searchedStartDate==null&&$searchedEndDate!=null){ 
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND found_date>='$searchedEndDate'  ";
                
        }else if($searchedName==null&&$searchedArea!=null&&$searchedCategory==null&&$searchedStartDate==null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND place_found LIKE '%{$searchedArea}%' AND found_date>='$searchedEndDate'  ";
            
        }else if($searchedName==null&&$searchedArea==null&&$searchedCategory!=null&&$searchedStartDate==null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND CATEGORY_category_ID='{$searchedCategory}' AND found_date>='$searchedEndDate'  ";
            
        }else if($searchedName!=null&&$searchedArea!=null&&$searchedCategory==null&&$searchedStartDate==null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND place_found LIKE '%{$searchedArea}%' AND found_date>='$searchedEndDate'  ";
            
        }else if($searchedName==null&&$searchedArea!=null&&$searchedCategory!=null&&$searchedStartDate==null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND place_found LIKE '%{$searchedArea}%' AND CATEGORY_category_ID='{$searchedCategory}' AND found_date>='$searchedEndDate'  ";
            
        }else if($searchedName!=null&&$searchedArea==null&&$searchedCategory!=null&&$searchedStartDate==null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND CATEGORY_category_ID='{$searchedCategory}' AND found_date>='$searchedEndDate'  ";
            
        }else if($searchedName!=null&&$searchedArea!=null&&$searchedCategory!=null&&$searchedStartDate==null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND place_found LIKE '%{$searchedArea}%' AND CATEGORY_category_ID='{$searchedCategory}' AND found_date>='$searchedEndDate'  ";
        
        }else if($searchedName==null&&$searchedArea==null&&$searchedCategory==null&&$searchedStartDate!=null&&$searchedEndDate!=null){ // end and start date
            $sqlStatementCondition="AND (found_date BETWEEN '$searchedStartDate' AND '$searchedEndDate') ";

            
        }else if($searchedName!=null&&$searchedArea==null&&$searchedCategory==null&&$searchedStartDate!=null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND (found_date BETWEEN '$searchedStartDate' AND '$searchedEndDate') ";
                
        }else if($searchedName==null&&$searchedArea!=null&&$searchedCategory==null&&$searchedStartDate!=null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND place_found LIKE '%{$searchedArea}%' AND (found_date BETWEEN '$searchedStartDate' AND '$searchedEndDate') ";
            
        }else if($searchedName==null&&$searchedArea==null&&$searchedCategory!=null&&$searchedStartDate!=null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND CATEGORY_category_ID='{$searchedCategory}' AND (found_date BETWEEN '$searchedStartDate' AND '$searchedEndDate') ";
            
        }else if($searchedName!=null&&$searchedArea!=null&&$searchedCategory==null&&$searchedStartDate!=null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND place_found LIKE '%{$searchedArea}%' AND (found_date BETWEEN '$searchedStartDate' AND '$searchedEndDate') ";
            
        }else if($searchedName==null&&$searchedArea!=null&&$searchedCategory!=null&&$searchedStartDate!=null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND place_found LIKE '%{$searchedArea}%' AND CATEGORY_category_ID='{$searchedCategory}' AND (found_date BETWEEN '$searchedStartDate' AND '$searchedEndDate') ";
            
        }else if($searchedName!=null&&$searchedArea==null&&$searchedCategory!=null&&$searchedStartDate!=null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND CATEGORY_category_ID='{$searchedCategory}' AND (found_date BETWEEN '$searchedStartDate' AND '$searchedEndDate') ";
            
        }else if($searchedName!=null&&$searchedArea!=null&&$searchedCategory!=null&&$searchedStartDate!=null&&$searchedEndDate!=null){
            $sqlStatementCondition=" AND description LIKE'%{$searchedName}%' AND place_found LIKE '%{$searchedArea}%' AND CATEGORY_category_ID='{$searchedCategory}' AND (found_date BETWEEN '$searchedStartDate' AND '$searchedEndDate') ";
        
        }
        $sqlStatementMain.=$sqlStatementCondition;
        $sqlStatementMain.=$sqlAfterStatements;
        $stmt=$conn->prepare($sqlStatementMain);
        echo $conn->error;
        $stmt->bind_param("i", $offset);
        echo $conn->error;
        $stmt->bind_result($id, $description, $day, $month, $year, $picture, $CATEGORY_category_ID, $place_found, $storage);
        $stmt->execute();

        while($stmt->fetch()){
            $response .= ' <div class="product flex-row">';
            $response .= '<a class="productImageBox" href="view_ad.php?id=' .$id ."&page=" .$page .'"><img class="productImage" src="' .$GLOBALS["pic_read_dir_thumb"] . $picture  .'"></a>';
            $response .= '<div class="flex-column productDesc">';
            $response .= '<p>Kirjeldus: ' . $description . '</p>';
            $response .= '<p>Leidmise koht: ' . $place_found . '</p>';
            $response .= '<p>Kuupäev: ' .$day .'.' .$monthsET[$month-1] .' ' .$year .'</p>';
            $response .= '<p>Hoiupaik: ' . $storage . '</p>';
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

    function selectStoragePlaceHTML() {
        $response = null;
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("SELECT storage_place_name, storage_place_ID FROM STORAGE_PLACE");
        echo $conn->error;
        $stmt->bind_result($storagePlaceName, $storageId);
        $stmt->execute();

        while($stmt->fetch()){
            $response .= '<option value="' . $storageId . '">' . $storagePlaceName . '</option>';
        }

        $response .= "\n";

        $stmt->close();
        $conn->close();
        return $response;
    }

    // If 12 months has passed since item was inserted, set expired to 1
    function foundToExpired() {
        $notice = null;
        $one = 1;
        $zero = 0;
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        mysqli_set_charset($conn,"utf8");
        $stmt = $conn->prepare("UPDATE FOUND_ITEM_AD SET expired=? WHERE DATEDIFF(NOW(), added_timestamp) > 12 AND auctioned is NULL AND deleted=?");
        
        echo $conn->error;
        $stmt->bind_param("ii", $one, $zero);
        $stmt->execute();

        if($stmt->execute()) {
            $notice = null;
        } else {
            $notice = "Andmete uuendamisel tekkis tõrge!" . $stmt->error;
        }

        $stmt->close();
        $conn->close();
        return $notice;
    }
    ////// HERMAN OKSJON FILTRATRSIOON FROM EXPIRED TO FUNCTION
    function auctionFiltration(){
        $start = auctionDefaultStartPrice();
        $biding = auctionDefaultStep();
		$notice = null;
        $expiredElement;
        $end_date = null;
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
  
        $stmt = $conn->prepare("INSERT INTO AUCTION (FOUND_ITEM_AD_found_item_ad_ID,step) VALUES(?,?)");
        echo $conn->error;
        $stmt->bind_param("id",$expiredElement,$biding);
        if($stmt->execute()){
            $notice = 1;
        } else {
            $notice = 0;
        }

        $stmt->close();
        
        $stmt = $conn->prepare("SELECT start_date FROM AUCTION WHERE FOUND_ITEM_AD_found_item_ad_ID = '{$expiredElement}'");
        echo $conn->error;
        $stmt->bind_result($start_time);
        $stmt->execute();
        if($stmt->fetch()){
            $end_date = date('Y-m-d H:i:s', strtotime($start_time. ' + 14 days'));
        }else{
            $notice = 404;
        }
        $stmt->close();

        $stmt = $conn->prepare("UPDATE AUCTION SET end_date = '{$end_date}' WHERE FOUND_ITEM_AD_found_item_ad_ID = '{$expiredElement}'");
        echo $conn->error;
        if($stmt->execute()){
            $notice = $end_date;
        }else{
            $notice = 404;
        }
        $stmt->close();

		$stmt = $conn->prepare("UPDATE  FOUND_ITEM_AD SET auctioned=1 WHERE  found_item_ad_ID='{$expiredElement}' ");
		if($stmt->execute()){
            $notice = "Tehtud!";
        }else{
            $notice = "Salvestamisel tekkis tehniline tõrge: " .$stmt->error;
        }
        $stmt->close();
        $stmt = $conn->prepare("SELECT auction_ID from AUCTION where FOUND_ITEM_AD_found_item_ad_ID='{$expiredElement}' AND expired IS NULL");
		echo $conn->error;
		$stmt->bind_result($id);
		$stmt->execute();
		if($stmt->fetch()){
            $auctionID = $id;
        } else {
            $notice = "ei toimi";
        }
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO OFFER (AUCTION_auction_ID,offer) VALUES(?,?)");
		echo $conn->error;
        $stmt->bind_param("id",$auctionID,$start);
        if($stmt->execute()){
            $notice = 1;
        } else {
            $notice = 0;
        }

		$stmt->close();   
        $conn->close();
        return $notice;
    }

    function setEmailNotification($id){
        $notice = null;
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("UPDATE LOST_ITEM_AD SET email_sent = 1 WHERE lost_post_ID = '{$id}'");
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

?>