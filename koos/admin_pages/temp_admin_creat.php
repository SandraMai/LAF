<?php
//Please delete this file after you have created your admin account

$pageTitle="LAF admin. Loo konto";
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

    $userName = validateMinMaxLength(cleanTextInput('username'));
    $password = validateMinMaxLength(cleanTextInput('password'));

    if (!isUsernameAvailable($userName)) {
        $userName = false;
        $notice = "Sellise nimega kasutaja on juba olemas.";
    }

    if($userName && $password){
        $notice = signUp($userName, $_POST["password"]);
    } elseif($notice == null) {
        $notice = "Ei saa salvestada, andmed on puudulikud!";
    }
}


?>

<body class="homeBody">

<?php require('../header.php'); ?>


<!-- IMAGE -->
<div>
    <div class="main-section titleSection">

        <h1 class="title flex-row white">LOO UUS KASUTAJA (ajutine abivahend)</h1>

        <p class="flex-row white " ><?php echo $passwordError; ?></p>
        <p class="flex-row white" ><?php echo $userNameError; ?></p>

        <!-- PAGE BODY -->
        <div class="flex-column logInFormBox"> 

            <form class="logInForm" action="" method="POST" name="admin_create_new_user_form">

                <div class="error-username"></div>
                <label class="flex-column logInInputBox">Kasutajanimi:<input type="text" name="username"></label><br>

                <div class="error-password"></div>
                <label class="flex-column logInInputBox">Parool:<input type="password" name="password"></label><br>
                <input class="logInButton" type="submit" value="Salvesta" name="create">
                <p><?php echo $notice;?></p>
            </form>
    

        </div><!--.main-section-->


    </div><!--.main-section-->
</div>




<script>
$(document).ready(function() {

    // Only letters, numbers, or dashes allowed
    $.validator.addMethod("aznumeric", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9]*$/i.test(value);
    });

    $('[name="admin_create_new_user_form"]').validate({
        rules: {
            username : {
                required: true,
                aznumeric: true,
                minlength: 8,
                maxlength: 30
            },
            password : {
                required: true,
                aznumeric: true,
                minlength: 8,
                maxlength: 30
            }
        },
        messages: {
            username: {
                required: "Palun sisestage kasutajatunnus.",
                aznumeric: "Lubatud on ainult numbrid ja tähed",
                minlength: "Palun sisestage vähemalt 8 karakterit",
                maxlength: "Palun sisestage maksimaalselt 30 karakterit"
            },
            password: {
                required: "Palun sisestage parool.",
                aznumeric: "Lubatud on ainult numbrid ja tähed",
                minlength: "Palun sisestage vähemalt 8 karakterit",
                maxlength: "Palun sisestage maksimaalselt 30 karakterit"
            }

        },
        errorPlacement: function(error, element) {
            // If input name is "storage", then error is appended to a class called "error-storage"
            // This system applies to all input elements stated in rules above
            error.appendTo( $('.error-' + element.attr("name")));
        }
    });

});

</script>
</body>
</html>