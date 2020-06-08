<?php   

    // ANETE
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

    // SANDRA
    require("index.php");
    $clothesCount = 0;
    $technologyCount = 0;
    $othersCount = 0;

    function counter($filter){

        if (isset($_POST["tehnika"])){
            $technologyCount++;
            echo $technologyCount;
        }
    }

    // LIINA
    // Add new found post
    function addFound() {
        $error = false;
        if ( isset($_POST['submitButton']) ) {

            $fileName = null;
            if (!empty($_FILES["image"]["name"])) {
                $fileName = saveImage();
            }

            $storage = cleanTextInput('storage');
            $date = cleanTextInput('date');
            $category = cleanIntInput('category');
            $description = cleanTextInput('description');

            if ($storage && $date && $fileName && $category && $description) {

                $error = insertFoundPost($storage, $date, $fileName, $category, $description);
            }
        }

        return $error;

    }

    // Cleans post request data
    function cleanTextInput($name) {
        if (isset($_POST[$name]) && !empty($_POST[$name])) {
            return htmlspecialchars($_POST[$name]);
        }
        return false;
    }

    function cleanIntInput($name) {
        return intval(cleanTextInput($name));
    }

    function saveImage() {
        $pic_upload_dir_orig = 'origimages/';
        $notice = null;
        $fileSizeLimit = 2500000;
        $pic_upload_dir_w600 = 'picuploadw600h400/';
        $maxPicW = 200;
        $maxPicH = 200;
        $fileNamePrefix = "laf_";
        $myPic = new PicUpload($_FILES["image"], $fileSizeLimit);
        if($myPic->error == null){
            $myPic->createFileName($fileNamePrefix);
            $myPic->resizeImage($maxPicW, $maxPicH);
            $notice .= $myPic->savePicFile($pic_upload_dir_w600 .$myPic->fileName);
            $notice .= " " .$myPic->saveOriginal($pic_upload_dir_orig .$myPic->fileName);
            return "http://" . $_SERVER['SERVER_NAME'] . '/oop_php/picuploadw600h400/' . $myPic->fileName;
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

    function postInsertedRedirect() {
        $url = "http://" . $_SERVER['SERVER_NAME'] . '/oop_php/' . 'post-added.php';
        header("Location: " . $url);
        exit();
    }
    
?>