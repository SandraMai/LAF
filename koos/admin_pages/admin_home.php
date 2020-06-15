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

?>



<body class="homeBody">
    <div class="main-flex header">
        <div class="aside"></div>

        <!-- HEADER -->
        <div class="main-section">
            <?php require('../header_admin.php'); ?>
        </div>
        <div class="aside"></div>

    </div><!--.main-flex-->

    <div class="main-flex page-body homeBody">
        <div class="aside"></div>

            <div class="main-section">

                <div class="flex-column"> 
                    <a class="adminHomeButton" href="lost.php">KAOTATUD ESEMED</a>
                    <a class="adminHomeButton" href="new_found.php">LEITUD ESEME LISAMINE</a>
                    <a class="adminHomeButton" href="found.php">LEITUD ESEMED</a>
                    <a class="adminHomeButton" href="auction.php">OKSJON</a>
                    <a class="adminHomeButton" href="auction.php">AEGUNUD KUULUUTSED</a>              
                    <a class="adminHomeButton" href="admin_settings.php">SEADED</a> 
                </div>
            </div>
        <div class="aside"></div>
    </div>

</body>
</html>