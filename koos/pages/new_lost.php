<?php
    require('../head.php');
    $flag = null;
    $case = 0;
    $notice = null;
    $respond = null;

    $filenamePrefix = "laf_";
    $maxH = 240;
    $maxW = 240;
    $fileSizeLimit = 2500000;    

    $email = null;
    $description = null;
    $lostDate = null;

    $today = date("Y-m-d");

    $email_error = null;
    $category_error = null;
    $description_error = null;
    $lostDate_error = null;

    if(isset($_POST["submitLost"])){        
        //e-maili kontroll
        if(isset($_POST["email"]) and !empty($_POST["email"])){
            if (emailValidation($_POST["email"])) {
                $email = test_input($_POST["email"]);
            }else {
                $email_error = "Ebakorrektne E-mail!";
                $notice = 404;
            }

        } else {
            $email_error = "Palun sisesta E-mail!";
            $notice = 404;
        }

        //kategooria kontroll
        if(isset($_POST["category"]) and !empty($_POST["category"]) ){
            if(rejectTags($_POST["category"]) ) {
                $category_error = null;
            } else {
                $notice = 404;
            }
            
        } else {
            $category_error = "Palun vali kategooria!";
            $notice = 404;
        }

        //kirjelduse kontroll
        if(isset($_POST["description"]) and !empty($_POST["description"])){

            if (rejectTags($_POST["description"])) {
                $description = test_input($_POST["description"]);
            } else {
                $description_error = "Palun sisestage ainult numbrid või tähed!";
                $notice = 404;
            }
            
        } else {
            $description_error = "Palun kirjelda kaotatud eset!";
            $notice = 404;
        }

        //kp kontroll; ei tohi olla tühi, ei tohi olla tulevikus
        if(isset($_POST["lostDate"]) and $_POST["lostDate"] > $today){
            $lostDate_error = "Kuupäev ei saa olla tulevikus!";
            $notice = 404;
        }elseif($_POST["lostDate"] == null){
            $lostDate_error = "Palun vali (umbes) kuupäev, millal eseme kaotasid!";
            $notice = 404;
        } else {
            if (rejectTags($_POST["lostDate"])) {
                $lostDate_error = null;
            } else {
                $notice = 404;
            }

        }  

        if(isset($_POST["placeLost"]) and !empty($_POST["placeLost"])){
            if(!rejectTags($_POST["placeLost"])) {
                $notice = 404;
            }
        } 
            
        //kui pilt olemas siis tehakse õige suurus, salvestatakse ja lisatakse kõik andmed andmebaasi
        if(isset($_FILES["lostPic"]) and !empty($_FILES["lostPic"]["name"]) and $notice !== 404){

            $picture = new PicUpload($_FILES["lostPic"], $fileSizeLimit);

            if($picture->error == null){
                //loome failinime
                $picture->createFileName($filenamePrefix);
                //teeme pildi väiksemaks
                $picture->resizeImage($maxW, $maxH);
                //kirjutame vähendatud pildi faili
                $picture->savePicFile($pic_upload_dir_thumb .$picture->fileName);  
                //salvestab originaali
                //$respond .= $picture->saveOriginal($pic_upload_dir_orig .$picture->fileName);                
                //salvestan info andmebaasi
                $respond .= addToDB($email, $_POST["lostDate"], $_POST["placeLost"], $picture->fileName, $description, $_POST["category"]);
                
                $notice = $respond;
            } else {
                //1 - pole pildifail, 2 - liiga suur, 3 - pole lubatud tüüp
                if($picture->error == 1){
                    $notice = 404;
                    $respond = " Valitud fail pole pilt!";
                }
                if($picture->error == 2){
                    $notice = 404;
                    $respond = " Valitud fail on liiga suure failimahuga!";
                }
                if($picture->error == 3){
                    $notice = 404;
                    $respond = "Valitud fail pole lubatud tüüpi (lubatakse vaid jpg, png)!";
                }
            }
            unset($picture);
            
 
        } else {

            if ($notice !== 404) {
                $picture = "puudub";
                $notice .= addToDB($email, $_POST["lostDate"], $_POST["placeLost"], $picture, $description, $_POST["category"]);
            }
            
        }

        if($notice == 1){
            $flag = 1;
            //redirectToLost();
        } elseif ($notice == 404) {
            $flag = 404;
        }
    }


?>

<body>

<?php require('../header.php'); ?>


    <div class="main-flex page-body">
        <div class="aside"></div>

        <div class="main-section">
            <!-- pealkiri  -->
            <div class="flex-row"> 
                <h1 class="title">LISA KAOTATUD KUULUTUS</h1>
            </div>
            <!-- kuulutuse lisamise vorm -->
            <form name="add_new_lost_form" class="flex-column" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">

                <div class="error-email"></div>
                <label class="foundLabel">
                    <p>
                        <span>E-mail</span><span class="star">&nbsp; *</span> <span><?php echo $email_error; ?></span>
                    </p>
                    <input class="foundInput textInput inputBoxStyle" name="email" value="<?php echo $email; ?>">
                </label>

                <div class="error-lostDate"></div>
                <label class="foundLabel">
                    <p>
                        <span>Kaotamise kuupäev</span><span class="star">&nbsp; *</span> <span><?php echo $lostDate_error; ?></span>
                    </p>
                    <input class="foundInput textInput inputBoxStyle" name="lostDate" type="date"
                     min="<?php echo date('Y-m-d', strtotime("-10 years"));?>" max="<?php echo date('Y-m-d');?>"> 
                </label>

                <div class="error-placeLost"></div>
                <label class="foundLabel">
                    <p>Kaotamise koht</p>
                    <input class="foundInput textInput inputBoxStyle" name="placeLost" type="text">
                </label>

                <label class="foundLabel fileLabel">
                    <p>Pilt</p>
                    <div class="fileInputBox foundInput inputBoxStyle">
                        <img src="../images/upload-file.png" alt="">
                    </div>
                    <p class="js-file-input-name"></p>
                    <input class="fileInput js-file-input"  name="lostPic" type="file" id="fileToUpload">
                </label>

                <div class="error-category"></div>
                <label class="foundLabel">
                    <p>
                        <span>Kategooria</span><span class="star">&nbsp; *</span><span><?php echo $category_error; ?></span>
                    </p>
                    
                    <select class="foundInput textInput inputBoxStyle" name="category">
                        <option disabled selected value>  Vali kategooria  </option>
                        <option value="riided">riided</option>
                        <option value="tehnika">tehnika</option>
                        <option value="muu">muu</option>
                    </select>
                
                </label>

                <div class="error-description"></div>
                <label class="foundLabel">

                    <p>
                        <span>Kirjeldus</span><span class="star">&nbsp; *</span> <span><?php echo $description_error; ?></span>
                    </p>
                    <textarea class="foundInput textInput inputBoxStyle" name="description"></textarea>
                    
                </label>

                <input name="submitLost" class="add-ad" id="add-lost" type="submit" value="LISA">
            </form>
        </div>
    <div class="aside"></div>
    </div>    



<!-- MODAL STUFF -->

<?php 

if ($flag == 1) {
    $case = 1;
} elseif ($flag == 404) {
    $case = 404;
}
?>

<input class="modalCase" type="hidden" data-case="<?php echo $case;?>">
<?php 

$url = "lost.php";
$urlTitle = 'Tagasi kaotatud rubriiki';
require('modal.php'); ?>

<script src="../js/lost.js"></script>
</body>
</html>