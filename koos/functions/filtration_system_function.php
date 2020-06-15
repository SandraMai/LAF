<?php 

function displayLostItems($filter, $offset,$searchedName,$searchedCategory,$searchedArea,$thisLink){
    if($searchedArea==null && $searchedName==null && $searchedCategory==null){
        $monthsET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
        $notice = null;
        $page = 'lost.php';
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        if($filter == null){
            $stmt = $conn->prepare("SELECT lost_post_ID, description, picture, lost_place, DATE_FORMAT(lost_date, '%d'), DATE_FORMAT(lost_date, '%c'), DATE_FORMAT(lost_date, '%Y') 
            FROM LOST_ITEM_AD WHERE expired = 0 AND deleted = 0 ORDER BY lost_post_ID DESC LIMIT 3 OFFSET ?");
            $stmt->bind_param("i", $offset);
        }else{
            $stmt = $conn->prepare("SELECT lost_post_ID, description, picture, lost_place, DATE_FORMAT(lost_date, '%d'), DATE_FORMAT(lost_date, '%c'), DATE_FORMAT(lost_date, '%Y')
            FROM LOST_ITEM_AD WHERE CATEGORY_category_ID = ? AND expired = 0 AND deleted = 0 ORDER BY lost_date DESC LIMIT 3 OFFSET ?");
            $stmt->bind_param("si", $filter, $offset);
        }
        echo $conn->error;
        $stmt->bind_result($id, $description, $pic, $place, $day, $month, $year);
        $stmt->execute();
        
        while($stmt->fetch()){
            if($pic=="puudub"){
                if($place == null){
                    $place = "Kaotamise koha kohta info puudub!";
                }
                $notice .= ' <div class="product">';
                $notice .= '<a class="productImageBox" href="view_ad.php?id=' .$id ."&page=" .$page .'"><img class="productImage" src="' .$GLOBALS["pic_read_dir_thumb"] ."missing.png" .'"></a>';
                $notice .= '<div class="productDesc">';
                $notice .= '<p> Kirjeldus: ' .$description .'</p>';
                $notice .= '<p>Kaotamise koht: ' .$place .'</p>';
                $notice .= '<p> Kaotamise kuupäev: ' .$day .'.' .$monthsET[$month-1] .' ' .$year .'</p>';
                $notice .= '</div></div>';
            }else{
                if($place == null){
                    $place = "Kaotamise koha kohta info puudub!";
                }
                $notice .= ' <div class="product">';
                $notice .= '<a class="productImageBox" href="view_ad.php?id=' .$id ."&page=" .$page .'"><img class="productImage" src="' .$GLOBALS["pic_read_dir_thumb"] .$pic .'"></a>';
                $notice .= '<div class="productDesc">';
                $notice .= '<p> Kirjeldus: ' .$description .'</p>';
                $notice .= '<p>Kaotamise koht: ' .$place .'</p>';
                $notice .= '<p> Kaotamise kuupäev: ' .$day .'.' .$monthsET[$month-1] .' ' .$year .'</p>';
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
    }else if($searchedArea!=null || $searchedName!=null || $searchedCategory!=null){
        $monthsET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
        $notice = null;
        $page = 'lost.php';
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        if($filter == null){
            $stmt = $conn->prepare("SELECT lost_post_ID, description, picture, lost_place, DATE_FORMAT(lost_date, '%d'), DATE_FORMAT(lost_date, '%c'), DATE_FORMAT(lost_date, '%Y') 
            FROM LOST_ITEM_AD WHERE expired = 0 AND description LIKE '%{$searchedName}%' AND deleted = 0 ORDER BY lost_post_ID DESC LIMIT 3 OFFSET ?");
            $stmt->bind_param("i", $offset);
        }else{
            $stmt = $conn->prepare("SELECT lost_post_ID, description, picture, lost_place, DATE_FORMAT(lost_date, '%d'), DATE_FORMAT(lost_date, '%c'), DATE_FORMAT(lost_date, '%Y')
            FROM LOST_ITEM_AD WHERE CATEGORY_category_ID = ? AND expired = 0 AND deleted = 0 ORDER BY lost_date DESC LIMIT 3 OFFSET ?");
            $stmt->bind_param("si", $filter, $offset);
        }
        echo $conn->error;
        $stmt->bind_result($id, $description, $pic, $place, $day, $month, $year);
        $stmt->execute();
        
        while($stmt->fetch()){
            if($pic=="puudub"){
                if($place == null){
                    $place = "Kaotamise koha kohta info puudub!";
                }
                $notice .= ' <div class="product">';
                $notice .= '<a class="productImageBox" href="view_ad.php?id=' .$id ."&page=" .$page .'"><img class="productImage" src="' .$GLOBALS["pic_read_dir_thumb"] ."missing.png" .'"></a>';
                $notice .= '<div class="productDesc">';
                $notice .= '<p> Kirjeldus: ' .$description .'</p>';
                $notice .= '<p>Kaotamise koht: ' .$place .'</p>';
                $notice .= '<p> Kaotamise kuupäev: ' .$day .'.' .$monthsET[$month-1] .' ' .$year .'</p>';
                $notice .= '</div></div>';
            }else{
                if($place == null){
                    $place = "Kaotamise koha kohta info puudub!";
                }
                $notice .= ' <div class="product">';
                $notice .= '<a class="productImageBox" href="view_ad.php?id=' .$id ."&page=" .$page .'"><img class="productImage" src="' .$GLOBALS["pic_read_dir_thumb"] .$pic .'"></a>';
                $notice .= '<div class="productDesc">';
                $notice .= '<p> Kirjeldus: ' .$description .'</p>';
                $notice .= '<p>Kaotamise koht: ' .$place .'</p>';
                $notice .= '<p> Kaotamise kuupäev: ' .$day .'.' .$monthsET[$month-1] .' ' .$year .'</p>';
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

}
?>