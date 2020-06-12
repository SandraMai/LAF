<?php

    // ANETE
    function test_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function redirectToLost(){
        header("Location: lost.php");
        exit();
    }    

    function addToDB($email, $lostDate, $placeLost, $filename, $description, $category){
        $notice = null;
        $categoryID = null;
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("SELECT category_ID FROM CATEGORY WHERE category_name=?");
        $stmt->bind_param("s", $category);
        $stmt->bind_result($categoryIDfromDB);
        $stmt->execute();
        if($stmt->fetch()){
            $categoryID = $categoryIDfromDB;
        } else {
            $notice = 404;//"ei toimi";
        }

        $stmt->close();    
        $stmt = $conn->prepare("INSERT INTO LOST_ITEM_AD (email, lost_date, lost_place, picture, CATEGORY_category_ID, description) VALUES(?,?,?,?,?,?)");
        echo $conn->error;
        $stmt->bind_param("ssssis", $email, $lostDate, $placeLost, $filename, $categoryID, $description);
        if($stmt->execute()){
            $notice = 1;
        } else {
            $notice = 404;//"pahasti" .$stmt->error;
        }
        
        $stmt->close();
        $conn->close();     
        return $notice;        
    }

    function readStoragePlaces(){
        $notice = null;
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("SELECT storage_place_name, phonenr, email FROM STORAGE_PLACE");
        $stmt->bind_result($name, $phone, $email);
        $stmt->execute();
        while($stmt->fetch()){
            $notice .= "<li><b>" .$name ."</b></li>";
            $notice .= "<li>Telefoninumber: " .$phone ."</li>";
            if($email != null){
                $notice .= "<li>Email: " .$email ."</li>";
            }
            $notice .= "<hr>";
        }
        $stmt->close();
        $conn->close();
        return $notice;
    }

    // LIINA
    // Adds new found post (validates, triggers database function)
    function addFound() {
        $error = null;
        if ( isset($_POST['submitButton']) ) {

            $fileName = null;
            if (!empty($_FILES["image"]["name"])) {
                $fileName = saveImage();
            }

            $storage = cleanTextInput('storage');
            $date = cleanTextInput('date');
            $category = cleanIntInput('category');
            $description = cleanTextInput('description');
            $found_location = cleanTextInput('found_location');

            if ($storage && $date && $fileName && $category && $description && $found_location) {
                $error = insertFoundPost($storage, $date, $fileName, $category, $description, $found_location);
            } else {
                $error = 404;
            }
            
        } 

        return $error;

    }

    // Cleans post request data
    function cleanTextInput($name) {
        if (isset($_POST[$name]) && !empty($_POST[$name])) {
            return rejectTags($_POST[$name]);
        }
        return false;
    }

    function cleanIntInput($name) {
        return intval(cleanTextInput($name));
    }

    function saveImage() {
        $pic_upload_dir_orig = $GLOBALS["pic_upload_dir_orig"];
        $notice = null;
        $fileSizeLimit = 2500000;
        $pic_upload_dir_w600 = $GLOBALS["pic_upload_dir_thumb"];
        $maxPicW = 200;
        $maxPicH = 200;
        $fileNamePrefix = "laf_";
        $myPic = new PicUpload($_FILES["image"], $fileSizeLimit);
        if($myPic->error == null){
            $myPic->createFileName($fileNamePrefix);
            $myPic->resizeImage($maxPicW, $maxPicH);
            $notice .= $myPic->savePicFile($pic_upload_dir_w600 .$myPic->fileName);
            $notice .= " " .$myPic->saveOriginal($pic_upload_dir_orig .$myPic->fileName);
            $returnString =  $myPic->fileName;
            return $returnString;
        } else {
            if($myPic->error == 1){
                $notice = "Üleslaadimiseks valitud fail pole pilt!";
            }
            if($myPic->error == 2){
                $notice = "Üleslaadimiseks valitud fail on liiga suure failimahuga!";
            }
            if($myPic->error == 3){
                $notice = "Üleslaadimiseks valitud fail pole lubatud tüüpi (lubatakse vaid jpg, png ja gif)!";
            }
            return $notice;

        }
    }
    // Does not work
    function postInsertedRedirect() {

        $url = dirname(__FILE__) . 'post_added.php';
        header("Location: " . $url);
        
        exit();
    }
    
    // Returns true if string consists of only numbers and digits
    function rejectTags($input) {
        if (ctype_alnum($input)) {
            return htmlspecialchars($input);
        } 
        return false;
    }

    function emailValidation($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
?>