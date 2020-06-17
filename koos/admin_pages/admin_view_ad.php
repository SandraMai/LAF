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
    $email = null;

    if(isset($_GET["id"])){
        $id = $_GET["id"];
        $notice = viewObjectAdmin($id, $page);
    }


    if(isset($_POST["sendEmail"])){
        if(!isset($_POST["storage"])){
            $emailNotice = "Vali hoiupaik";
        }else{
            $email = getEmail($_POST["adId"]);
            $message = "Teie kaotatud ese (kirjeldus: " .getDescription($_POST["adId"]) .") on jõudnud hoiupaika: " 
            .getStorage($_POST["storage"]);
            $message .= ". Palun tule esemele järele! \r\n Ära sellele meilile vasta! \r\n Sinu LAF <3";
            //$message = wordwrap($message, 70, "\r\n");
            mail($email, "TLÜ LAF", $message);
            $emailNotice = "email saadetud!";
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
                    echo $notice;
                    echo $emailNotice;
                ?>

            </div>
        </div>
    </div>
    <div class="aside"></div>
</div>

</div>


</body>
</html>