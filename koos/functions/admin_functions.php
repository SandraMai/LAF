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


?>