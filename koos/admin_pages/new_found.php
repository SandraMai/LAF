<?php require('../head.php');


if(!isset($_SESSION["userId"])){
    header("Location: admin_login.php");
    exit();
}

if(isset($_GET["logout"])){
  session_unset();
  session_destroy();
  header("Location: admin_login.php");
  exit();
}


// LIINA 
// -- Modal logic start
// Post added: flag needs to return false(or null)
// Post not added: flag needs to return true(or anything)
$flag = null;
$flag = addFound();

$case = 0;

// -- Modal logic end
if ($flag == 1) {
    $case = 1;
} elseif ($flag == 404) {
    $case = 404;
}
?>
<body>


<div class="main-flex header">
    <div class="aside"></div>

    <!-- HEADER -->
    <div class="main-section">
        <?php require('../header_admin.php'); ?>
    </div>
    <div class="aside"></div>

</div>

<div class="main-flex page-body">
    <div class="aside"></div>

    <div class="main-section">

        <div class="flex-row"> 
            <h1 class="title">LISA LEITUD KUULUTUS</h1>
        </div>

        <form class="flex-column" action="" method="POST" name="add_new_found_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">

            <div class="error-storage"></div>
               <label class="foundLabel">
                <p>Hoiupaik</p>
                <select class="foundInput textInput inputBoxStyle" name="storage">
                    <option disabled selected value>  Vali hoiupaik  </option>
                    <?php echo selectStoragePlaceHTML();?>
                </select>
            </label>

            <br>

            <div class="error-date"></div>
            <label class="foundLabel">
            <p>Leidmise kuupäev</p>
            
                <input class="foundInput textInput inputBoxStyle" type="date" name="date"
                    
                    min="<?php echo date('Y-m-d', strtotime("-14 days"));?>" max="<?php echo date('Y-m-d');?>">
            </label>
            <br>

            <div class="error-found_location"></div>
            <label class="foundLabel">
            <p>Leidmise asukoht</p>
                <input class="foundInput textInput inputBoxStyle" type="text" name="found_location">
            </label>
            <br>


            <div class="error-image"></div>
            <label class="foundLabel fileLabel">
                <p>Pilt</p>
                <div class="fileInputBox foundInput inputBoxStyle">
                    <img src="../images/upload-file.png" alt="">
                </div>
                <p class="js-file-input-name"></p>
                <input class="fileInput js-file-input" name="image" type="file">
            </label>
            <br>

            <div class="error-category"></div>
            <label class="foundLabel">
                <p>Kategooria</p>
                <select class="foundInput textInput inputBoxStyle" name="category">
                    <option disabled selected value>  Vali kategooria  </option>
                    <option value="1">riided</option>
                    <option value="2">tehnika</option>
                    <option value="3">muu</option>
                </select>
            </label>
            <br>

            <div class="error-description"></div>
            <label class="foundLabel">
                <p>Kirjeldus</p>
                <textarea class="foundInput textInput inputBoxStyle" name="description" id="" cols="30" rows="5"></textarea>
            </label>
            <br>

               <input class="add-ad" type="submit" value="LISA" name="submitButton">
        
        </form><!--.flex-row-->

    </div>



    <div class="aside"></div>
</div>


<!-- MODAL STUFF -->
<input class="modalCase" type="hidden" data-case="<?php echo $case;?>">
<?php 

$url = "found.php";
$urlTitle = 'Tagasi leitud rubriiki';
require('modal.php'); ?>

<script src="../js/found.js"></script>

</body>
</html>