<?php

function insertFoundPost($storage, $date, $fileName, $category, $description) {
    $response = null;
    $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $stmt = $conn->prepare("INSERT INTO leitud_kuulutus (kirjeldus,leidmise_kp,pilt) VALUES(?,?,?)");
    echo $conn->error;
    $stmt->bind_param("sss", $description, $date, $fileName);
    if($stmt->execute()) {
        $response = "Andmete salvestamine õnnestus!";
    } else {
        $response = "Andmete salvestamisel tekkis tehniline tõrge: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    postInsertedRedirect();
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