<?php

require("../../../../config_laf.php");
require('../classes/Picupload.class.php');
require('../functions/functions.php');
require('../functions/admin_functions.php');
require('../functions/database_functions.php');
require("../functions/oksjon_functions.php");
require("../functions/admin_oksjon_functions.php");
require("../functions/admin_filtration.php");
$database = "if19_LAF";

?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAF</title>
    <script
    src="https://code.jquery.com/jquery-3.4.1.js"
    integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
    crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha256-+BEKmIvQ6IsL8sHcvidtDrNOdZO3C9LtFPtF2H0dOHI=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js" integrity="sha256-dppmU3M7PmToUPE0IZQEFK+v6GJaz5YzVOZN+uxRiDw=" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <script src="../lib/jquery-autoheight.js"></script>
    <script src="../js/active.js"></script>
    <script src="../js/global.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../style.css">
</head>