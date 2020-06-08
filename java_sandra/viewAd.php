<?php
    require("head.php");
    require("../../../config_laf20.php");
    require("functions_database.php");
    $database = 'if19_anete_va_1';
    $notice = null;
    $id = null;
    $notice = null;

    if(isset($_GET["id"])){
        $id = $_GET["id"];
        $notice = viewObject($id);
    }
?>

<body>
    <div class="main-flex header">
        <div class="main-section">
            <?php require("header.php"); ?>
        </div>
    </div>
    <div class="main-flex">
        <div class="objects flex-column">

            <?php echo $notice ?>

        </div>
    </div>
</body>