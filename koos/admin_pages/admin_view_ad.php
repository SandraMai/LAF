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
    $emailNotice = null;
    $id = null;

    if(isset($_GET["id"])){
        $id = $_GET["id"];
        $page = $_GET["page"];
        $notice = viewObjectAdmin($id, $page);
    }

    $email = getEmail($id);
    $message = "JAHSJAHSJAHSJAHSJAHJSKHAJKs";

    if(isset($_POST["sendEmail"])){
        mail($email, "Tere", $message);
        $emailNotice = "email saadetud!";
    }else{
        $emailNotice = "vali hoiupaik!";
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
                    echo $notice;
                ?>

            </div>
        </div>
    </div>
    <div class="aside"></div>
</div>

</div>


</body>
</html>