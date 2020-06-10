<?php require('../head.php'); 

// LIINA 
// -- Modal logic start
// Post added: flag needs to return false(or null)
// Post not added: flag needs to return true(or anything)
$flag = true;
$flag = addFound();

$case = 0;
if (!$flag) {
    $case = 1;
}
// -- Modal logic end

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

        <div class="flex-row"> 
            <h1 class="title">LISA LEITUD KUULUTUS</h1>
        </div>

        <form class="flex-column" action="" method="POST" name="add_new_found_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">

            <div class="error-storage"></div>
               <label>
                Hoiupaik
                <select name="storage">
                    <option disabled selected value> -- select an option -- </option>
                    <?php echo selectStoragePlaceHTML();?>
                </select>
            </label>

            <br>

            <div class="error-date"></div>
            <label>Leidmise kuupäev
                <input type="date" name="date"
                    
                    min="2020-01-01" max="2020-06-10">
            </label>
            <br>

            <div class="error-found_location"></div>
            <label>Leidmise asukoht
                <input type="text" name="found_location">
            </label>
            <br>


            <div class="error-image"></div>
            <label>
                Pilt
                <input name="image" type="file">
            </label>
            <br>

            <div class="error-category"></div>
            <label>
                Kategooria
                <select name="category">
                    <option disabled selected value> -- select an option -- </option>
                    <option value="1">riided</option>
                    <option value="2">tehnika</option>
                    <option value="3">muu</option>
                </select>
            </label>
            <br>

            <div class="error-description"></div>
            <label>
                Kirjeldus
                <textarea name="description" id="" cols="30" rows="5"></textarea>
            </label>
            <br>


               <input type="submit" value="SAADA" name="submitButton">
        
        </form><!--.flex-row-->

    </div>



    <div class="aside"></div>
</div>


<!-- MODAL STUFF -->
<input class="modalCase" type="hidden" data-case="<?php echo $case;?>">
<?php require('modal.php'); ?>

<script src="../js/found.js"></script>
</body>
</html>