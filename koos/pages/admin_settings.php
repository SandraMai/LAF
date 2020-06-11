<?php 
    require('../head.php'); 
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
                    <h1 class="title">SEADED</h1>
                </div>

                <div class="flex-column"> 
                    <a class="admin-settings" href="">ÜLDSEADED</a>
                    <a class="admin-settings" href="">MUUDA PAROOLI</a>
                    <a class="admin-settings" href="">KKK <br> LEHE MUUTMINE</a>
                    <a class="admin-settings" href="admin_storage.php">HOIUPAIGAD</a>     
                    
                </div>
            </div>
        <div class="aside"></div>
    </div>

</body>
</html>