<?php
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
?>