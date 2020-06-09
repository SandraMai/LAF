<?php 


require('../head.php'); 




?>

<body class="homeBody">



<div class="main-flex header">
    <div class="aside"></div>

    <!-- HEADER -->
    <div class="main-section">
        <?php require('../header.php'); ?>
    </div>
    <div class="aside"></div>

</div><!--.main-flex-->

<!-- IMAGE -->
<div>
    <div class="main-section homeSection">

        <h1 class="title flex-row">ADMIN</h1>
        <!-- PAGE BODY -->
        <div class="flex-column homeTextWrap"> 

            <!-- <h3>Lost and Found</h3>
            <br>
            <h4>Siia veebisaidile võib lisada Tallinna Ülikoolis kaotatud esemeid või otsida leitute hulgast.</h4>
            <br>
            <a href="found.php">LEITUD ESEMEID SIRVIMA</a> -->

            <form action="" method="POST">
                kasutajanimi
                <input type="text">
            </form>


        </div><!--.main-section-->





    </div><!--.main-section-->
</div>


</body>
</html>