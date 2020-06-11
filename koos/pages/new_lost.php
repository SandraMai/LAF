<?php
    require('../head.php');
    $case = 0;
    $notice = null;
    $respond = null;

    $filenamePrefix = "laf_";
    $maxH = 200;
    $maxW = 200;
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
            $email = test_input($_POST["email"]);
        } else {
            $email_error = "Palun sisesta E-mail!";
            $notice = 0;
        }

        //kategooria kontroll
        if(isset($_POST["category"]) and !empty($_POST["category"])){
            $category_error = null;
        } else {
            $category_error = "Palun vali kategooria!";
            $notice = 0;
        }

        //kirjelduse kontroll
        if(isset($_POST["description"]) and !empty($_POST["description"])){
            $description = test_input($_POST["description"]);
        } else {
            $description_error = "Palun kirjelda kaotatud eset!";
            $notice = 0;
        }

        //kp kontroll; ei tohi olla tühi, ei tohi olla tulevikus
        if(isset($_POST["lostDate"]) and $_POST["lostDate"] > $today){
            $lostDate_error = "Kuupäev ei saa olla tulevikus!";
            $notice = 0;
        }elseif($_POST["lostDate"] == null){
            $lostDate_error = "Palun vali (umbes) kuupäev, millal eseme kaotasid!";
            $notice = 0;
        } else {
            $lostDate_error = null;
        }    
            
        //kui pilt olemas siis tehakse õige suurus, salvestatakse ja lisatakse kõik andmed andmebaasi
        if(isset($_FILES["lostPic"]) and !empty($_FILES["lostPic"]["name"])){

            $picture = new PicUpload($_FILES["lostPic"], $fileSizeLimit);

            if($picture->error == null){
                //loome failinime
                $picture->createFileName($filenamePrefix);
                //teeme pildi väiksemaks
                $picture->resizeImage($maxW, $maxH);
                //kirjutame vähendatud pildi faili
                $respond .= $picture->savePicFile($pic_upload_dir_thumb .$picture->fileName);  
                //salvestab originaali
                //$respond .= $picture->saveOriginal($pic_upload_dir_orig .$picture->fileName);                
                //salvestan info andmebaasi
                $respond .= addToDB($email, $_POST["lostDate"], $_POST["placeLost"], $picture->fileName, $description, $_POST["category"]);
                if($notice == 1){
                    $case = 1;
                   //redirectToLost();
                }
            } else {
                //1 - pole pildifail, 2 - liiga suur, 3 - pole lubatud tüüp
                if($picture->error == 1){
                    $notice = 0;
                    $respond = " Valitud fail pole pilt!";
                }
                if($picture->error == 2){
                    $notice = 0;
                    $respond = " Valitud fail on liiga suure failimahuga!";
                }
                if($picture->error == 3){
                    $notice = 0;
                    $respond = "Valitud fail pole lubatud tüüpi (lubatakse vaid jpg, png)!";
                }
            }
            unset($picture);
            $case = 1;
 
        } else {
            $picture = "puudub";
            $notice .= addToDB($email, $_POST["lostDate"], $_POST["placeLost"], $picture, $description, $_POST["category"]);
            $case = 1;
        }

        if($notice == 1){
            $case = 1;
            //redirectToLost();
        }
        
    }


?>

<body>
    <div class="main-flex header">
        <div class="aside"></div>
        <!-- HEADER -->
        <div class="main-section">
            <?php require('../header.php'); ?>
        </div>
        <div class="aside"></div>
    </div>

    <div class="main-flex page-body">
        <div class="aside"></div>

        <div class="main-section">
            <!-- pealkiri  -->
            <div class="flex-row"> 
                <h1 class="title">LISA KUULUTUS</h1>
            </div>
            <!-- kuulutuse lisamise vorm -->
            <form class="flex-column" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">

                <label class="lostLabel">E-mail 
                <input name="email" type="email" value="<?php echo $email; ?>">
                <p class="star">*</p> <span><?php echo $email_error; ?></span>
                </label>

                <label class="lostLabel">Kaotamise kuupäev
                <input name="lostDate" type="date"> 
                <p class="star">*</p> <span><?php echo $lostDate_error; ?></span>
                </label>

                <label class="lostLabel">Kaotamise koht
                <input name="placeLost" type="text">
                </label>

                <label class="lostLabel">Pilt
                <input name="lostPic" type="file" id="fileToUpload">
                </label>

                <label class="lostLabel">Kategooria
                    <select name="category">
                    <option disabled selected value>...</option>
                    <option value="riided">riided</option>
                    <option value="tehnika">tehnika</option>
                    <option value="muu">muu</option>
                    </select>
                <p class="star">*</p> <span><?php echo $category_error; ?></span>
                </label>

                <label class="lostLabel">Kirjeldus
                <textarea rows="3" cols="30" name="description"><?php echo $description; ?></textarea>
                <p class="star">*</p> <span><?php echo $description_error; ?></span>
                </label>

                <input name="submitLost" class="add-ad" id="add-lost" type="submit" value="LISA"> <span><?php echo $respond; ?> </span>
            </form>
        </div>
    <div class="aside"></div>
    </div>    



<!-- MODAL STUFF -->
<input class="modalCase" type="hidden" data-case="<?php echo $case;?>">
<?php require('modal.php'); ?>

<script src="../js/found.js"></script>
</body>
</html>