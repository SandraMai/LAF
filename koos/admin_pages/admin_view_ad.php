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
    


    if(isset($_GET["id"])){
        $id = $_GET["id"];
        $page = $_GET["page"];
        $notice = viewObjectAdmin($id, $page);
    }

    if(isset($_POST["deleteAd"])){
        $id = $_POST["idInput"];
        $notice = deleteLostAdAdmin($id);
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
    <div class="view"></div>
        <div class="flex-row"> 
            <div class="products">
                <?php echo $notice;?>
            </div>
        </div>
    </div>
    <div class="aside"></div>
</div>

</div>
</body>