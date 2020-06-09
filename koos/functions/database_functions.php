<?php
    // SANDRA
    function displayLostItems($filter){
        $notice = null;
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        if($filter == null){
            $stmt = $conn->prepare("SELECT id, description, filename, lost_place, DATE_FORMAT(lost_date, '%d %M %Y') FROM laf_lost ORDER BY lost_date DESC");
        }else{
            $stmt = $conn->prepare("SELECT id, description, filename, lost_place, DATE_FORMAT(lost_date, '%d %M %Y') FROM laf_lost WHERE category = ? ORDER BY lost_date DESC");
            $stmt->bind_param("s", $filter);
        }
        echo $conn->error;
        $stmt->bind_result($id, $description, $pic, $place, $date);
        $stmt->execute();
        while($stmt->fetch()){
            $notice .= ' <div class="object flex-row">';
            $notice .= '<a href="viewAd.php?id=' .$id .'"><img src="' .$GLOBALS["picDir"] .$pic .'"></a>';
            $notice .= '<div>';
            $notice .= '<p> Kirjeldus: ' .$description .'</p>';
            $notice .= '<p>Kaotamise koht: ' .$place .'</p>';
            $notice .= '<p> Kaotamise kuupäev: ' .$date .'</p>';
            $notice .= '</div></div>';
        }
        if($notice == null){
            $notice = '<p>Hetkel asju pole!</p>';
        }
        $stmt->close();
        $conn->close();
        return $notice;
    }

    function viewObject($id){
        $notice = null;
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("SELECT id, description, filename, lost_place, DATE_FORMAT(lost_date, '%d %M %Y'), email FROM laf_lost WHERE id='{$id}'");
        echo $conn->error;
        $stmt->bind_result($id, $description, $pic, $place, $date, $email);
        $stmt->execute();
        while($stmt->fetch()){
            $notice .= ' <div class="object flex-row">';
            $notice .= '<img src="' .$GLOBALS["picDir"] .$pic .'">';
            $notice .= '<div>';
            $notice .= '<p>Kirjeldus: ' .$description .'</p>';
            $notice .= '<p>Kaotamise koht: ' .$place .'</p>';
            $notice .= '<p> Kaotamise kuupäev: ' .$date .'</p>';
            $notice .= '<p>Kontakt: ' .$email .'</p>';
            $notice .= '</div></div>';
        }
        
        $stmt->close();
        $conn->close();
        return $notice;
    }

    // LIINA
    function insertFoundPost($storage, $found_date, $fileName, $category, $description, $placeFound) {
        $response = null;
        $zero = 0;
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("INSERT INTO found_item_ad (found_date,place_found,picture,expired,description,CATEGORY_category_ID,deleted,STORAGE_PLACE_storage_place_ID) VALUES(?,?,?,?,?,?,?,?)");
        echo $conn->error;
        $stmt->bind_param("sssisiii", $found_date, $placeFound, $fileName, $zero, $description, $category, $zero, $storage);
        if($stmt->execute()) {
            $response = "Andmete salvestamine õnnestus!";
        } else {
            $response = "Andmete salvestamisel tekkis tehniline tõrge: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
        // Does not work
        //postInsertedRedirect();
    }


    function selectFoundPostsHTML() {
        $response = null;
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("SELECT kirjeldus,leidmise_kp,pilt,KATEGOORIA_kategooria_ID,leidmise_koht FROM leitud_kuulutus WHERE aegunud=0");
        echo $conn->error;
        $stmt->bind_result($kirjeldus, $leidmise_kp, $pilt, $KATEGOORIA_kategooria_ID, $leidmise_koht);
        $stmt->execute();

        while($stmt->fetch()){
        $response .= ' <div class="product flex-row">';
        $response .= '<img  src="' . $pilt . '">';
        $response .= '<div>';
        $response .= '<p>' . $kirjeldus . '</p>';
        $response .= '<p>' . $leidmise_koht . '</p>';
        $response .= '<p>' . $leidmise_kp . '</p>';
        $response .= '</div><div class="aside"></div></div>';
        }

        $response .= "\n";

        $stmt->close();
        $conn->close();
        return $response;
    }

    function selectStoragePlaceHTML() {
        $response = null;
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("SELECT storage_place_name, storage_place_ID FROM storage_place");
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

?>