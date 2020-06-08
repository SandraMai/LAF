<?php   
    
    function test_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function redirect(){
        $url = 'http://' .$_SERVER['SERVER_NAME'] .'/~sandrmai/objektprog/LAF/index.php';
        header("Location: " .$url);
        exit();
    }    

    function addToDB($studentCode, $email, $lostDate, $placeLost, $filename, $category, $description){
        $notice = null;
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("INSERT INTO laf_lost (student_code, email, lost_date, lost_place, filename, category, description) VALUES(?,?,?,?,?,?,?)");
        echo $conn->error;
        $stmt->bind_param("sssssss", $studentCode, $email, $lostDate, $placeLost, $filename, $category, $description);
        if($stmt->execute()){
            $notice = " Kuulutus edukalt lisatud!";
        } else {
            $notice = " Kuulutuse lisamisel tekkis tõrge-> " .$stmt->error;
        }
        $stmt->close();
        $conn->close();     

        redirect();
        return $notice;
         
    }
?>