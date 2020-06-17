<?php
    require("../head.php");
    require("../../../../config_laf.php");

    if(isset($_SESSION["LAST_ACTIVITY"]) && (time() - $_SESSION["LAST_ACTIVITY"] > 1800)){
        session_unset(); 
        session_destroy();  
        header("Location: admin_login.php");
        exit();
    }

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

    $notice = null;
    $id = null;
    $deletedNotice = null;
    $case = 0;
    


    if(isset($_GET["id"])){
        $id = $_GET["id"];
        $page = $_GET["page"];
        $notice = viewObjectAdmin($id, $page);
    }

    if(isset($_POST["deleteAd"])){
        $id = $_POST["idInput"];
        $notice = deleteLostAdAdmin($id);
        if($notice == 2) {
            $case = 2;
        } elseif ($notice == 404) {
            $case = 10;
        }
    }
?>

<body>

<?php require('../header_admin.php'); ?>


    <div class="main-flex page-body">
    <div class="aside"></div>

    <div class="main-section">
    <div class="view"></div>
        <div class="flex-row"> 
            <div class="products">

                <?php 
                if ( $notice != 2 && $notice != 404):
                    echo $notice;
                endif;
                ?>

            </div>
        </div>
    </div>
    <div class="aside"></div>
</div>

</div>


<input class="modalCase" type="hidden" data-case="<?php echo $case;?>">
<?php 

$url = "admin_lost.php";
$urlTitle = 'Tagasi kaotatud rubriiki';
require('../pages/modal.php'); ?>

<script src="../js/lost.js"></script>

</body>
</html>