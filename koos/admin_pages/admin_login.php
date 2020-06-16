<?php 

require('../head.php');

$notice = null;
$usernameError = null;
$passwordError = null;


if(isset($_POST["login"])){

  if (isset($_POST["username"]) && !empty($_POST["username"])){
    $userName = test_input($_POST["username"]);
  } else {
    $usernameError = "Palun sisesta kasutajanimi!";
  }
  
  if (!isset($_POST["password"]) || empty($_POST["password"])){
    $passwordError = "Palun sisesta parool!";
  }
  
  if(empty($usernameError) && empty($passwordError)){
    $notice = logIn($userName, $_POST["password"]);

  } else {
    $notice = "Sisesta oma kasutajanimi ja parool";
  }
}

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

        <p class="flex-row white " ><?php echo $notice; ?></p>

        <!-- PAGE BODY -->
        <div class="flex-column logInFormBox"> 

            <form class="logInForm" action="" method="POST">
                <label class="flex-column logInInputBox">Kasutajanimi:<input type="text" name="username"></label><br>
                <label class="flex-column logInInputBox">Parool:<input type="password" name="password"></label><br>
                <input class="logInButton" type="submit" value="Logi sisse" name="login">
            </form>


        </div><!--.main-section-->


    </div><!--.main-section-->
</div>


</body>
</html>