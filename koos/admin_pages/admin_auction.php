<?php 
    require('../head.php');

    $adminLinkValue=3;
    $case = 0;

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

    $start = auctionDefaultStartPrice();
    $step = auctionDefaultStep();

    if(isset($_POST["submitAuction"])){
        $notice = updateAuction($_POST["start-price"], $_POST["step"]);
        if($notice == 2) {
            $case = 7;
        } elseif ($notice == 404) {
            $case = 10;
        }
        $notice = null;
        $start = auctionDefaultStartPrice();
        $step = auctionDefaultStep();


    }
?>
<body>

<?php require('../header_admin.php'); ?>


    <div class="main-flex page-body">
        <div class="aside"></div>

            <div class="main-section">
                <!-- pealkiri  -->
                <div class="flex-row"> 
                    <h1 class="title">OKSJONI SEADED</h1>
                </div>
                <form class="flex-column" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
        
                <label class="storageLabel">Oksjoni alghind
                <input name="start-price" class="auction-input" type="number" min="0.1" step="0.1" value="<?php echo $start; ?>">    
                </label> 
                

                <label class="storageLabel">Oksjoni pakkumise samm
                <input name="step" class="auction-input" type="number" min="0.1" step="0.1" value="<?php echo $step; ?>">
                
                </label>

                <input name="submitAuction" class="add-ad" type="submit" value="SALVESTA"> <span><?php echo $notice; ?></span>
                
                </form>

            </div>
        <div class="aside"></div>
    </div>

<input class="modalCase" type="hidden" data-case="<?php echo $case;?>">
<?php 

$url = "admin_settings.php";
$urlTitle = 'Tagasi seadetesse';
require('../pages/modal.php'); ?>
</body>
</html>