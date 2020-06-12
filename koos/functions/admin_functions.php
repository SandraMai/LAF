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

    function addNewStorageToDB($newStorageName, $newPhonenr){
        $notice = null;
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("INSERT INTO STORAGE_PLACE (storage_place_name, phonenr) VALUES(?,?)");
        $stmt->bind_param("ss", $newStorageName, $newPhonenr);
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
?>