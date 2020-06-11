<?php 
    require('../head.php'); 

    $notice = null;
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
                    <input name="new-password" class="password-input" type="password" value="<?php ?>">
                    <span><?php  ?></span>
                    
                    <br>

                    <label>Uus parool uuesti</label>
                    <input name="new-password-again" class="password-input" type="password" value="<?php ?>">
                    <span><?php?></span>
                    <br>
                    <input name="submitNewPassword" class="password-button" type="submit" value="MUUDA PAROOLI"> <span><?php echo $notice; ?></span>
                    <input name="cancel" class="password-button" type="submit" value="TÜHISTA"> <span><?php echo $notice; ?></span>
                        
                </form>
                </div>
                
            </div>
        <div class="aside"></div>
    </div>

</body>
</html>