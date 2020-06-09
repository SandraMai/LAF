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
    <div class="main-section titleSection">

        <h1 class="title flex-row white">ADMIN</h1>
        <!-- PAGE BODY -->
        <div class="flex-column logInFormBox"> 

            <form class="logInForm" action="" method="POST">
                <label class="flex-column logInInputBox">Kasutajanimi:<input type="text" name="kasutajanimi"></label><br>
                <label class="flex-column logInInputBox">Parool:<input type="password" name="password"></label><br>
                <input class="logInButton" name="login" type="submit" value="Logi sisse">
            </form>


      <!--  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  <label>E-mail (kasutajatunnus):</label><br>
	  <input type="email" name="email" value="<?php echo $email; ?>">&nbsp;<span><?php echo $emailError; ?></span><br>
	  
	  <label>Salasõna:</label><br>
	  <input name="password" type="password">&nbsp;<span><?php echo $passwordError; ?></span><br>
	  
	  <input name="login" type="submit" value="Logi sisse">&nbsp;<span><?php echo $notice; ?>
	</form>
    -->
    

        </div><!--.main-section-->





    </div><!--.main-section-->
</div>


</body>
</html>