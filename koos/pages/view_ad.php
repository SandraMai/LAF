<?php
    $pageTitle="Kuulutus";
    require("../head.php");
    require("../../../../config_laf.php");

    $notice = null;
    $id = null;
    $deletedNotice = null;
    $emailError = null;
    $case = 0;

    if(isset($_GET["id"])){
        $id = $_GET["id"];
        $page = $_GET["page"];
        $notice = viewObject($id, $page);
    }

    if(isset($_POST["deleteAd"])){
        $email = test_input($_POST["email"]);
        if(isset($_POST["email"]) and !empty($_POST["email"])){
            if(checkEmail($id, $email) == 1){
                $deletedNotice = deleteAd($id);
                if ($deletedNotice == 2) {
                    $emailError = "Kuulutus on kustutatud!";
                    $case = 2;
                } elseif ($deletedNotice == 404) {
                    $case = 10;
                }
                
            }else{
                $emailError = "E-mailid ei klapi!";
            }
        }else{
            $emailError = "Palun sisesta E-mail!";
        }
    }


?>
<head>
    <script src="../js/delete.js"></script>
</head>
<body>

    <?php require('../header.php'); ?>


<div class="main-flex page-body">
<div class="aside"></div>
<div class="main-section">

    <?php if($deletedNotice != 2):?>
            <div class="view"></div>
                <div class="flex-row">
                    <div class="products">
                        <?php echo $notice;?>
                    </div>
                </div>
                <div class="flex-row"> 
                    <div class ="phpError">
                        <?php echo $emailError; ?>
                    </div>
                </div>
    <?php endif;?>
</div>
<div class="aside"></div>
</div>

</div>



<?php 


?>

<input class="modalCase" type="hidden" data-case="<?php echo $case;?>">
<?php 

$url = "lost.php";
$urlTitle = 'Tagasi kaotatud rubriiki';
require('modal.php'); ?>

<script src="../js/lost.js"></script>

</body>
</html>