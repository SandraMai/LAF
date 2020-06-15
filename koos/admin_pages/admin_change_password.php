<?php 
    require('../head.php');
    
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
    $newPassword_error = null;

    if(isset($_POST["submitNewPassword"])){ 
        if(strlen($_POST["new-password"]) < 8 && strlen($_POST["new-password-again"]) < 8){
            $newPassword_error = "Uus parool on liiga lühike!";
        }

        if(empty($_POST["new-password-again"])){
            $newPassword_error = "Palun sisesta parool teist korda ka!";
        } else {
            if(($_POST["new-password"] != $_POST["new-password-again"])){            
                $newPassword_error = "Paroolid ei ole samasugused!";
            }
        }
        
        

        if($newPassword_error == null){
            $password = $_POST["new-password"];
            $notice = updatePassword($password);
        }        
    }

    if(isset($_POST["cancel"])){
        header("Location: admin_settings.php");
        exit();
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

    </div><!--.main-flex-->

    <div class="main-flex page-body">
        <div class="aside"></div>

            <div class="main-section">
                <!-- pealkiri  -->
                <div class="flex-row"> 
                    <h1 class="title">PAROOL</h1>
                </div>

                <div class="flex-column">
                    <form class="password-box flex-column" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
            
                    <label>Uus parool</label>
                    <input name="new-password" class="password-input" type="password">                   
                    <br>

                    <label>Uus parool uuesti</label>
                    <input name="new-password-again" class="password-input" type="password">
                    <br>
                    <p class="star">Jaga töötajatele uut parooli!</p>
                    <input name="submitNewPassword" class="password-button" type="submit" value="MUUDA PAROOLI"> <span><?php echo $notice; echo $newPassword_error; ?></span>
                    <input name="cancel" class="password-button" type="submit" value="TÜHISTA">
                        
                </form>
                </div>
                
            </div>
        <div class="aside"></div>
    </div>

</body>
</html>