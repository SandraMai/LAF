<?php

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
            $notice = " Telefoninumber uuendatud!";
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
              $notice = "Vale parool!";
            }
          } else {
          $notice = "Sellist kasutajat (" .$userName .") ei leitud!";
            }
        } else {
          $notice = "Sisselogimisel tekkis tehniline viga!" .$stmt->error;
        }
      $stmt->close();
      $mysqli->close();
      return $notice;
    }

    function updatePassword($newPassword, $newPasswordagain){
      $notice = null;
      $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
      $stmt = $conn->prepare("UPDATE ADMIN SET password = ? WHERE admin_ID = ?");
      echo $conn->error;
      $stmt->bind_param("i", $_SESSION["userID"]);
      $stmt->bind_result($passwordFromDb);
      if($stmt->execute()){
        $options = ["cost" => 12, "salt" => substr(sha1(rand()), 0, 22)];
          $pwdhash = password_hash($newPassword,PASSWORD_BCRYPT, $options);
          $stmt->bind_param("si", $pwdhash, $_SESSION["userID"]);
          if($stmt->execute()){
            $notice = "Uue parooli salvestamine õnnestus!";
          } else {
            $notice = "Parooli salvestamisel tekkis tehniline viga: " .$stmt->error;
          }
        }
      $stmt->close();
      $conn->close();
      return $notice;
    }
?>