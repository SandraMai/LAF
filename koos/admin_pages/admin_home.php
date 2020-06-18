<?php

$pageTitle="LAF admin";

require('../head.php');

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

?>



<body class="homeBody">

<?php require('../header_admin.php'); ?>


    <div class="main-flex page-body homeBody">
        <div class="aside"></div>

            <div class="main-section">

                <div class="flex-column"> 
                    <a class="adminHomeButton" href="admin_lost.php">KAOTATUD ESEMED</a>
                    <a class="adminHomeButton" href="new_found.php">LEITUD ESEME LISAMINE</a>
                    <a class="adminHomeButton" href="admin_found.php">LEITUD ESEMED</a>
                    <a class="adminHomeButton" href="admin_successful.php">OKSJON</a>
                    <a class="adminHomeButton" href="admin_expired.php">AEGUNUD KUULUUTSED</a>              
                    <a class="adminHomeButton" href="admin_settings.php">SEADED</a> 
                </div>
            </div>
        <div class="aside"></div>
    </div>

</body>
</html>