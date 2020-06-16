<?php
//Please delete this file after you have created your admin account

require('../head.php');

$notice = null;
$userName = null;
$password = null;

$userNameError = null;
$passwordError = null;


function signUp($userName, $password){
	$notice = null;
	$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("INSERT INTO ADMIN (username, password) VALUES(?,?)");
	echo $conn->error;
	
	$options = ["cost" => 12, "salt" => substr(sha1(rand()), 0, 22)];
	$pwdhash = password_hash($password, PASSWORD_BCRYPT, $options);
	
	$stmt->bind_param("ss",$userName, $pwdhash);
	
	if($stmt->execute()){
		$notice = "Kasutaja salvestamine õnnestus!";
	
	}else {
		$notice = "kasutaja salvestamisel tekkis tehniline tõrge: " .$stmt->error;
	}
	
	$stmt->close();
	$conn->close();
	return $notice;
}


if(isset($_POST["create"])){
    if(isset($_POST["username"]) && !empty($_POST["username"])){
        $userName = test_input($_POST["username"]);
    } else {
        $userNameError = "Palun sisesta oma kasutajanimi!";
    }
      
    if(!isset($_POST["password"]) || empty($_POST["password"])){
        $passwordError = "Palun sisesta parool!";
    } else {
        if(strlen($_POST["password"]) < 8){
            $passwordError = "Liiga lühike parool. Miinimum on 8 tähemärki";
        }
    }

    if(empty($userNameError) and empty($passwordError)){
        $notice = signUp($userName, $_POST["password"]);
    } else {
        $notice = "Ei saa salvestada, andmed on puudulikud!";
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

        <h1 class="title flex-row white">LOO UUS KASUTAJA (ajutine abivahend)</h1>

        <p class="flex-row white " ><?php echo $passwordError; ?></p>
        <p class="flex-row white" ><?php echo $userNameError; ?></p>

        <!-- PAGE BODY -->
        <div class="flex-column logInFormBox"> 

            <form class="logInForm" action="" method="POST">
                <label class="flex-column logInInputBox">Kasutajanimi:<input type="text" name="username"></label><br>
                <label class="flex-column logInInputBox">Parool:<input type="password" name="password"></label><br>
                <input class="logInButton" type="submit" value="Salvesta" name="create">
            </form>
    

        </div><!--.main-section-->


    </div><!--.main-section-->
</div>


</body>
</html>