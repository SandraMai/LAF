<?php
    require('../head.php');

    $notice = null;
    $filenamePrefix = "laf_";
    $maxH = 200;
    $maxW = 200;
    $fileSizeLimit = 2500000;    

    $email = null;
    $description = null;
    $lostDate = null;

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
        }
        //kategooria kontroll
        if(isset($_POST["category"]) and !empty($_POST["category"])){
            $category_error = null;
        } else {
            $category_error = "Palun vali kategooria!";
        }
        //kirjelduse kontroll
        if(isset($_POST["description"]) and !empty($_POST["description"])){
            $description = test_input($_POST["description"]);
        } else {
            $description_error = "Palun kirjelda kaotatud eset!";
        }

        //kp kontroll
        if(isset($_POST["lostDate"]) and !empty($_POST["lostDate"])){
            $lostDate_error = null;
        } else {
            $lostDate_error = "Palun pane (umbes) kuupäev, millal eseme kaotasid!";
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
                $notice .= $picture->saveImage($pic_upload_dir_thumb .$picture->fileName);  
                //salvestab originaali
                $notice .= $picture->saveOriginal($pic_upload_dir_orig .$picture->fileName);                
                //salvestan info andmebaasi
                $notice .= addToDB($email, $_POST["lostDate"], $_POST["placeLost"], $picture->fileName, $description, $_POST["category"]);
            } else {
                //1 - pole pildifail, 2 - liiga suur, 3 - pole lubatud tüüp
                if($picture->error == 1){
                    $notice = " Valitud fail pole pilt!";
                }
                if($picture->error == 2){
                    $notice = " Valitud fail on liiga suure failimahuga!";
                }
                if($picture->error == 3){
                    $notice = "Valitud fail pole lubatud tüüpi (lubatakse vaid jpg, png)!";
                }
            }
            unset($picture);

        } else {
            $picture = "puudub";
            $notice .= addToDB($email, $_POST["lostDate"], $_POST["placeLost"], $picture, $description, $_POST["category"]);
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

                <label>E-mail 
                <input name="email" type="email" value="<?php echo $email; ?>">
                <p>*</p> <span><?php echo $email_error; ?></span>
                </label>

                <label>Kaotamise kuupäev
                <input name="lostDate" type="date"> 
                <p>*</p>
                </label>

                <label>Kaotamise koht
                <input name="placeLost" type="text">
                </label>

                <label>Pilt
                <input name="lostPic" type="file" id="fileToUpload">
                </label>

                <label>Kategooria
                    <select name="category">
                    <option disabled selected value>...</option>
                    <option value="riided">riided</option>
                    <option value="tehnika">tehnika</option>
                    <option value="muu">muu</option>
                    </select>
                <p>*</p> <span><?php echo $category_error; ?></span>
                </label>

                <label>Kirjeldus
                <textarea rows="3" cols="30" name="description" value="<?php echo $description; ?>"></textarea>
                <p>*</p> <span><?php echo $description_error; ?></span>
                </label>

                <input name="submitLost" id="submit-button" type="submit" value="LISA"> <span><?php echo $notice; ?> </span>
            </form>
        </div>
    <div class="aside"></div>
    </div>    
</body>