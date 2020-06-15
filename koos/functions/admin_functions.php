<?php
  session_start();

    function readStoragesForSelect(){
        $storageHTML = null;
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("SELECT storage_place_ID, storage_place_name FROM STORAGE_PLACE");
        $stmt->bind_result($id, $storage_name);
        $stmt->execute();
        while($stmt->fetch()){
            $storageHTML .= '<option value="' .$id .'"';
            $storageHTML .= '>' .$storage_name .'</option> \n';
        }
        $stmt->close();
	    $conn->close();
	    return $storageHTML;
    }

    function readSectionForSelect(){
      $sectionHTML = null;
      $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
      $stmt = $conn->prepare("SELECT section_ID, section_name FROM SECTION");
      $stmt->bind_result($id, $section_name);
      $stmt->execute();
      while($stmt->fetch()){
          $sectionHTML .= '<option value="' .$id .'"';
          $sectionHTML .= '>' .$section_name .'</option> \n';
      }
      $stmt->close();
      $conn->close();
      return $sectionHTML;
    }

    function addNewStorageToDB($newStorageName, $newPhonenr, $email){
        $notice = null;
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("INSERT INTO STORAGE_PLACE (storage_place_name, phonenr, email) VALUES(?,?,?)");
        $stmt->bind_param("sss", $newStorageName, $newPhonenr, $email);
        if($stmt->execute()){
            $notice = "Uus hoiupaik lisatud!";
        } else {
            $notice = "Midagi läks valesti: " .$stmt->error;
        }
        $stmt->close();
        $conn->close();
        return $notice;
    }

    function updateStorage($storageID, $phonenr){
        $notice = null;
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("UPDATE STORAGE_PLACE SET phonenr=? WHERE storage_place_ID='{$storageID}'");
        $stmt->bind_param("s", $phonenr);
        if($stmt->execute()){
            $notice = "Telefoninumber uuendatud!";
        } else {
            $notice = "Midagi läks valesti: " .$stmt->error;
        }
        $stmt->close();
        $conn->close();
        return $notice;
    }

    function logIn($userName, $password){
        $notice = "";
        $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        $stmt = $mysqli->prepare("SELECT password FROM ADMIN WHERE username=?");
        echo $mysqli->error;
        $stmt->bind_param("s", $userName);
        $stmt->bind_result($passwordFromDb);
        if($stmt->execute()){
          if($stmt->fetch()){
          if(password_verify($password, $passwordFromDb)){
            $stmt->close();
            $stmt = $mysqli->prepare("SELECT admin_ID FROM ADMIN WHERE username=?");
            echo $mysqli->error;
            $stmt->bind_param("s", $userName);
            $stmt->bind_result($idFromDb);
            $stmt->execute();
            $stmt->fetch();
            $stmt->close();
            $mysqli->close();
            $_SESSION["userId"] = $idFromDb;
            header("Location: admin_home.php");
            exit();
            } else {
              $notice = "Vale kasutajanimi või parool!";
            }
          } else {
          $notice = "Vale kasutajanimi või parool!";
            }
        } else {
          $notice = "Sisselogimisel tekkis tehniline viga!" .$stmt->error;
        }
      $stmt->close();
      $mysqli->close();
      return $notice;
    }

    function updatePassword($newPassword){
      $notice = null;
      $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
      $stmt = $conn->prepare("UPDATE ADMIN SET password=? WHERE admin_ID=?");
      echo $conn->error;
      $options = ["cost" => 12, "salt" => substr(sha1(rand()), 0, 22)];
      $pwdhash = password_hash($newPassword, PASSWORD_BCRYPT, $options);
      $stmt->bind_param("si", $pwdhash, $_SESSION["userId"]);
      if($stmt->execute()){
            $notice = "Uue parooli salvestamine õnnestus!";
      } else {
            $notice = "Parooli salvestamisel tekkis tehniline viga: " .$stmt->error;
      }
      $stmt->close();
      $conn->close();
      return $notice;
    }

    function updateAuction($startPrice, $step){
      $notice = null;
      $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
      $stmt = $conn->prepare("UPDATE OFFER_CHANGE SET start_price=?, offer_step=?");
      echo $conn->error;
      $stmt->bind_param("dd", $startPrice, $step);
      if($stmt->execute()){
        $notice = "Uuendus õnnestus!";
      } else {
        $notice = "Tekkis tehniline viga: " .$stmt->error;
      }
      $stmt->close();
      $conn->close();
      return $notice;
    }

    function auctionDefaultStartPrice(){
      $start = null;
      $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
      $stmt = $conn->prepare("SELECT start_price FROM OFFER_CHANGE");
      $stmt->bind_result($startDB);
      $stmt->execute();
      if($stmt->fetch()){
        $start = $startDB;
      } else {
        $start = $stmt->error;
      }
      $stmt->close();
      $conn->close();
      return $start;
    }

    function auctionDefaultStep(){
      $step = null;
      $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
      $stmt = $conn->prepare("SELECT offer_step FROM OFFER_CHANGE");
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

    function addFAQ($sectionID, $question, $answer){
      $notice = null;
      $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
      $stmt = $conn->prepare("INSERT INTO FAQ (question, answer, SECTION_section_ID) VALUES (?,?,?)");
      $stmt->bind_param("ssi", $question, $answer, $sectionID);
      if($stmt->execute()){
        $notice = "Uus korduma kippuv küsimus lisatud!";
      } else {
        $notice = "Midagi läks valesti" .$stmt->error;
      }
      $stmt->close();
      $conn->close();
      return $notice;
    }

    function displayLostItemsAdmin($filter){
      $monthsET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
      $notice = null;
      $page = basename($_SERVER['PHP_SELF']);
      $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
      if($filter == null){
          $stmt = $conn->prepare("SELECT lost_post_ID, description, picture, lost_place, DATE_FORMAT(lost_date, '%d'), DATE_FORMAT(lost_date, '%c'), DATE_FORMAT(lost_date, '%Y') 
          FROM LOST_ITEM_AD WHERE expired = 0 AND deleted = 0 ORDER BY lost_post_ID DESC");
      }else{
          $stmt = $conn->prepare("SELECT lost_post_ID, description, picture, lost_place, DATE_FORMAT(lost_date, '%d'), DATE_FORMAT(lost_date, '%c'), DATE_FORMAT(lost_date, '%Y')
          FROM LOST_ITEM_AD WHERE CATEGORY_category_ID = ? AND expired = 0 AND deleted = 0 ORDER BY lost_date DESC");
          $stmt->bind_param("s", $filter);
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
              $notice .= '<a class="productImageBox" href="admin_view_ad.php?id=' .$id ."&page=" .$page .'"><img class="productImage" src="' .$GLOBALS["pic_read_dir_thumb"] ."missing.png" .'"></a>';
              $notice .= '<div class="productDesc">';
              $notice .= '<p> Kirjeldus: ' .$description .'</p>';
              $notice .= '<p>Kaotamise koht: ' .$place .'</p>';
              $notice .= '<p> Kaotamise kuupäev: ' .$day .'.' .$monthsET[$month-1] .' ' .$year .'</p>';
              $notice .= '<input type="submit" class="deleteFormButton" id="' .$id .'" name="delete" value="KUSTUTA">';
              $notice .= '</div></div>';
          }else{
              if($place == null){
                  $place = "Kaotamise koha kohta info puudub!";
              }
              $notice .= ' <div class="product">';
              $notice .= '<a class="productImageBox" href="admin_view_ad.php?id=' .$id ."&page=" .$page .'"><img class="productImage" src="' .$GLOBALS["pic_read_dir_thumb"] .$pic .'"></a>';
              $notice .= '<div class="productDesc">';
              $notice .= '<p> Kirjeldus: ' .$description .'</p>';
              $notice .= '<p>Kaotamise koht: ' .$place .'</p>';
              $notice .= '<p> Kaotamise kuupäev: ' .$day .'.' .$monthsET[$month-1] .' ' .$year .'</p>';
              $notice .= '<input type="submit" class="deleteFormButton" id="' .$id .' name="delete" value="KUSTUTA">';
              $notice .= '</div></div>';
          }
      }
      if($notice == null){
          $notice .= '<p class="flex-row">Hetkel esemeid pole!</p>';
      }
      $stmt->close();
      $conn->close();
      return $notice;
  }

  function deleteAdAdmin($id){
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

  function viewObjectAdmin($id, $page){
    $monthsET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
    $notice = null;
    $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    if($page=="admin_lost.php"){
        $stmt = $conn->prepare("SELECT description, picture, lost_place, DATE_FORMAT(lost_date, '%d'), DATE_FORMAT(lost_date, '%c'), DATE_FORMAT(lost_date, '%Y'), email FROM LOST_ITEM_AD WHERE lost_post_ID='{$id}'");
        echo $conn->error;
        $stmt->bind_result($description, $pic, $place, $day, $month, $year, $email);
        $stmt->execute();
        while($stmt->fetch()){
            if($pic=="puudub"){
                if($place == null){
                    $place = "Kaotamise koha kohta info puudub!";
                }
                $notice .= '<div class="product flex-row >';
                $notice .= '<img class="productImageBox" src="' .$GLOBALS["pic_read_dir_thumb"] ."missing.png" .'">';
                $notice .= '<div class="productDesc">';
                $notice .= '<p class="text"> Kirjeldus: ' .$description .'</p>';
                $notice .= '<p class="text">Kaotamise koht: ' .$place .'</p>';
                $notice .= '<p class="text">Kaotamise kuupäev: ' .$day .'.' .$monthsET[$month-1] .' ' .$year .'</p>';
                $notice .= '<p class="text">E-mail: '. $email .'</p>';
                $notice .= '<button id="delete">KUSTUTA</button>';
                $notice .= '<select name="admin-view-ad">' .readStoragesForSelect();
                $notice .= '</select>';
                //$notice .= '<form id="deleteForm" method="POST">';
                //$notice .= '<input class="deleteFormButton" type="submit" value="KUSTUTA" name="deleteAd"></form>';
                $notice .= '</div></div>';
            }else{
                if($place == null){
                    $place = "Kaotamise koha kohta info puudub!";
                }
                $notice .= '<div class="product flex-row">';
                $notice .= '<img class="productImageBox" src="' .$GLOBALS["pic_read_dir_thumb"] .$pic .'">';
                $notice .= '<div class="productDesc">';
                $notice .= '<p class="text">Kirjeldus: ' .$description .'</p>';
                $notice .= '<p class="text">Kaotamise koht: ' .$place .'</p>';
                $notice .= '<p class="text">Kaotamise kuupäev: ' .$day .'.' .$monthsET[$month-1] .' ' .$year .'</p>';
                $notice .= '<p class="text">E-mail: '. $email .'</p>';
                $notice .= '<button id="delete">KUSTUTA</button>';
                $notice .= '<select name="admin-view-ad">' .readStoragesForSelect();
                $notice .= '</select>';
                $notice .= '<form id="deleteForm" method="POST">';
                $notice .= '<input class="deleteFormButton" type="submit" value="KUSTUTA" name="deleteAd"></form>';
                $notice .= '</div></div>';
            }
        }
        $stmt->close();
        $conn->close();
        return $notice;
    }
  }
  function selectFoundPostsAdmin() {
    $response = null;
    $monthsET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
    $page = basename($_SERVER['PHP_SELF']);
    $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $stmt = $conn->prepare("SELECT found_item_ad_ID, description,DATE_FORMAT(found_date, '%d'), DATE_FORMAT(found_date, '%c'), DATE_FORMAT(found_date, '%Y'),picture,CATEGORY_category_ID,place_found, storage_place_name
    FROM FOUND_ITEM_AD JOIN STORAGE_PLACE ON FOUND_ITEM_AD.STORAGE_PLACE_storage_place_ID = STORAGE_PLACE.storage_place_ID WHERE expired=0 ORDER BY found_item_ad_ID DESC");
    echo $conn->error;
    $stmt->bind_result($id, $description, $day, $month, $year, $picture, $CATEGORY_category_ID, $place_found, $storage);
    $stmt->execute();

    while($stmt->fetch()){
    $response .= ' <div class="product flex-row">';
    $response .= '<img class="productImage" src="' .$GLOBALS["pic_read_dir_thumb"] . $picture  .'"></a>';
    $response .= '<div class="flex-column productDesc">';
    $response .= '<p>Kirjeldus: ' . $description . '</p>';
    $response .= '<p>Leidmise koht:' . $place_found . '</p>';
    $response .= '<p>Kuupäev: ' .$day .'.' .$monthsET[$month-1] .' ' .$year .'</p>';
    $response .= '<p>Hoiupaik: ' . $storage . '</p>';
    $response .= '<form method="POST" action="#"><input type ="hidden" value="' .$id .'" name="idInput">';
    $response .= '<input type="submit" id="delete" name="deleteAd" value="KUSTUTA"></form>';
    $response .= '</div><div class="aside"></div></div>';
    }
    if($response == null){
        $response .= '<p class="flex-row">Hetkel esemeid pole!</p>';
    }
    $response .= "\n";

    $stmt->close();
    $conn->close();
    return $response;
}
?>