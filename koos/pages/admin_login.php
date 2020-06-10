<?php 


require('../head.php');

$notice = null;
$emailError = null;
$passwordError = null;

function signIn($userName, $password){
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT password FROM ADMIN WHERE username=?");
	echo $mysqli->error;
	$stmt->bind_param("s", $userName);
	$stmt->bind_result($passwordFromDb);
	if($stmt->execute()){
		//kui päring õnnestus
	  if($stmt->fetch()){
		//kasutaja on olemas
		if(password_verify($password, $passwordFromDb)){
		  //kui salasõna klapib
		  $stmt->close();
		  $stmt = $mysqli->prepare("SELECT username FROM ADMIN WHERE username=?");
		  echo $mysqli->error;
		  $stmt->bind_param("s", $userName);
		  $stmt->bind_result($userNameFromDb);
		  $stmt->execute();
		  $stmt->fetch();
		  $notice = "Sisse logis " .$userNameFromDb ."!";
		  
		  
		} else {
		  $notice = "Vale salasõna!";
		}//kas password_verify
	  } else {
		$notice = "Sellist kasutajat (" .$userName .") ei leitud!";
		//kui sellise e-kasutajaga ei saanud vastet (fetch ei andnud midagi), siis pole sellist kasutajat
	  }//kas fetch õnnestus
	} else {
	  $notice = "Sisselogimisel tekkis tehniline viga!" .$stmt->error;
	  //veateade, kui execute ei õnnestunud
	}//kas execute õnnestus
	
	$stmt->close();
	$mysqli->close();
	return $notice; 
  }//sisselogimine lõppeb


//sisselogimine
if(isset($_POST["login"])){
    if (isset($_POST["username"]) and !empty($_POST["username"])){
      $userName = test_input($_POST["username"]);
    } else {
      $emailError = "Palun sisesta kasutajatunnus!";
    }
    
    if (!isset($_POST["password"]) or strlen($_POST["password"]) < 4){
      $passwordError = "Palun sisesta parool, vähemalt 8 märki!";
    }
    
    if(empty($emailError) and empty($passwordError)){
      $notice = signIn($userName, $_POST["password"]);
    } else {
      $notice = "Ei saa sisse logida!";
    }
    }//kas POST login

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
                <label class="flex-column logInInputBox">Kasutajanimi:<input type="text" name="username"></label><br>
                <label class="flex-column logInInputBox">Parool:<input type="password" name="password"></label><br>
                <input class="logInButton" type="submit" value="Logi sisse" name="login">
            </form>
        <?php echo $notice; 
                echo $passwordError;
                echo $emailError; ?>

        </div><!--.main-section-->





    </div><!--.main-section-->
</div>


</body>
</html>