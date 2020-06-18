<?php
  session_start();

    function getFaqQuestions(){
      $notice = null;
      $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
      $stmt = $conn->prepare("SELECT faq_ID, question FROM FAQ");
      echo $conn->error;
      $stmt->bind_result($id, $question);
      $stmt->execute();
      while($stmt->fetch()){
        $notice .= '<option value="' .$id .'"';
        $notice .= '>' .$question .'</option>';
      }
      $stmt->close();
      $conn->close();
      return $notice;
    }

    function getFaqAnswers(){
      $notice = null;
      $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
      $stmt = $conn->prepare("SELECT faq_ID, answer FROM FAQ");
      echo $conn->error;
      $stmt->bind_result($id, $answer);
      $stmt->execute();
      while($stmt->fetch()){
        $notice .= '<option value="' .$id .'"';
        $notice .= '>' .$answer .'</option>';
      }
      $stmt->close();
      $conn->close();
      return $notice;
    }

    function updateFaqQuestion($id, $question){
      $notice = null;
      $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
      $stmt = $conn->prepare("UPDATE FAQ SET question=? WHERE faq_ID='{$id}'");
      $stmt->bind_param("s", $question);
      if($stmt->execute()){
            $notice = 2;
      } else {
            $notice = 404;
      }
      $stmt->close();
      $conn->close();
      return $notice;
    }

    function updateFaqAnswer($id, $answer){
      $notice = null;
      $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
      $stmt = $conn->prepare("UPDATE FAQ SET answer=? WHERE faq_ID='{$id}'");
      $stmt->bind_param("s", $answer);
      if($stmt->execute()){
            $notice = 2;
      } else {
            $notice = 404;
      }
      $stmt->close();
      $conn->close();
      return $notice;
    }

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
                $notice = 2;
        } else {
                $notice = 404;
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
                $notice = 2;
        } else {
                $notice = 404;
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
            $_SESSION["LAST_ACTIVITY"] = time();
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
            $notice = 2;
      } else {
            $notice = 404;
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
            $notice = 2;
      } else {
            $notice = 404;
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
            $notice = 2;
      } else {
            $notice = 404;
      }
      $stmt->close();
      $conn->close();
      return $notice;
    }

    

  function deleteLostAdAdmin($id){
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

  function viewObjectAdmin($id){
    $monthsET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
    $notice = null;
    $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    
        $stmt = $conn->prepare("SELECT lost_post_ID, description, picture, lost_place, DATE_FORMAT(lost_date, '%d'), DATE_FORMAT(lost_date, '%c'), DATE_FORMAT(lost_date, '%Y'), email, email_sent FROM LOST_ITEM_AD WHERE lost_post_ID='{$id}'");
        echo $conn->error;
        $stmt->bind_result($id, $description, $pic, $place, $day, $month, $year, $email, $emailSent);
        $stmt->execute();
        while($stmt->fetch()){
            if($pic=="puudub"){
                if($place == null){
                    $place = "Kaotamise koha kohta info puudub!";
                }
                $notice .= '<div class="product flex-row">';
                $notice .= '<img class="productImageBox" src="../images/missing.png">';
                $notice .= '<div class="productDesc">';
                $notice .= '<p class="text"> Kirjeldus: ' .$description .'</p>';
                $notice .= '<p class="text">Kaotamise koht: ' .$place .'</p>';
                $notice .= '<p class="text">Kaotamise kuupäev: ' .$day .'.' .$monthsET[$month-1] .' ' .$year .'</p>';
                $notice .= '<p class="text">E-mail: '. $email .'</p></div>';                
                if($emailSent == 0){
                  $notice .= '<form class="flex-column emailForm" method="POST" action="' .htmlspecialchars($_SERVER["PHP_SELF"]) .'" enctype="multipart/form-data">';
                  $notice .= '<select name = "storage"> <option selected disabled value>Vali hoiupaik</option>' .readStoragesForSelect();
                  $notice .= '</select> <input type ="hidden" value="' .$id .'" name="adId"> <input name="sendEmail" class="add-ad" type="submit" value="Saada meil">';
                  $notice .= '</form></div>';
                } else {
                  $notice .= '<p class="emailForm">E-mail on juba saadetud!</p></div>';
                }
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
                $notice .= '<p class="text">E-mail: '. $email .'</p></div>';
                if($emailSent == 0){
                  $notice .= '<form class="flex-column emailForm" method="POST" action="' .htmlspecialchars($_SERVER["PHP_SELF"]) .'" enctype="multipart/form-data">';
                  $notice .= '<select name = "storage"> <option selected disabled value>Vali hoiupaik</option>' .readStoragesForSelect();
                  $notice .= '</select> <input type ="hidden" value="' .$id .'" name="adId"> <input name="sendEmail" class="add-ad" type="submit" value="Saada meil">';
                  $notice .= '</form></div>';
                } else {
                  $notice .= '<p class="emailForm">E-mail on juba saadetud!</p></div>';
                }
            }
        }
        $stmt->close();
        $conn->close();
        return $notice;
    
  }
  function getEmail($id){
    $notice = null;
    $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $stmt = $conn->prepare("SELECT email FROM LOST_ITEM_AD WHERE lost_post_ID = '{$id}'");
    echo $conn->error;

    $stmt->bind_result($email);
    $stmt->execute();

    if($stmt->fetch()){
      $notice = $email;
      echo $email;
    }else{
      $notice = "404";
    }

    $stmt->close();
    $conn->close();
    return $notice;

  }

  function getStorage($id){
    $notice = null;
    $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $stmt = $conn->prepare("SELECT storage_place_name FROM STORAGE_PLACE  WHERE storage_place_ID = '{$id}'");
    echo $conn->error;

    $stmt->bind_result($storage);
    $stmt->execute();

    if($stmt->fetch()){
      $notice = $storage;
    }else{
      $notice = "404";
    }

    $stmt->close();
    $conn->close();
    return $notice;
  }

  function getDescription($id){
    $notice = null;
    $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $stmt = $conn->prepare("SELECT description FROM LOST_ITEM_AD WHERE lost_post_ID = '{$id}'");
    echo $conn->error;

    $stmt->bind_result($description);
    $stmt->execute();

    if($stmt->fetch()){
      $notice = $description;
    }else{
      $notice = "404";
    }

    $stmt->close();
    $conn->close();
    return $notice;
  }
  
  function deleteFoundAdmin($id){
    $response = null;
    $one = 1;
    $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $stmt = $conn->prepare("UPDATE FOUND_ITEM_AD SET deleted = ? WHERE found_item_ad_ID = ?");
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

  function validateMinMaxLength($value) {
      if(strlen($value) < 30 && strlen($value) > 8) {
          return $value;
      }
      return false;
  }

  function isUsernameAvailable($value) {
    $notice = null;
    $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $stmt = $conn->prepare("SELECT admin_ID FROM ADMIN WHERE username = '{$value}'");
    echo $conn->error;
    $stmt->bind_result($id);
    $stmt->execute();

    if($stmt->fetch()){
      $notice = false;
    }else{
      $notice = true;
    }

    $stmt->close();
    $conn->close();
    return $notice;
  }

    function areEqual($value1, $value2) {
        if ($value1 == $value2) {
            return true;
        }
        return false;
    }
?>