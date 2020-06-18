<?php 

$pageTitle="LAF admin. Sisselogimine";

require('../head.php');

$notice = null;

if(isset($_POST["login"])){

    $userName = validateMinMaxLength(cleanTextInput('username'));
    $password = validateMinMaxLength(cleanTextInput('password'));
  
  if($userName && $password){
    $notice = logIn($userName, $_POST["password"]);
  } else {
    $notice = "Sisesta oma kasutajanimi ja parool";
  }
}

?>

<body class="homeBody">

<?php require('../header.php'); ?>


<!-- IMAGE -->
<div>
    <div class="main-section titleSection">

        <h1 class="title flex-row white">ADMIN</h1>

        <p class="flex-row white " ><?php echo $notice; ?></p>

        <!-- PAGE BODY -->
        <div class="flex-column logInFormBox"> 

            <form class="logInForm" name="admin_login_form" action="" method="POST">

                <div class="error-username"></div>
                <label class="flex-column logInInputBox">Kasutajanimi:<input type="text" name="username"></label><br>

                <div class="error-password"></div>
                <label class="flex-column logInInputBox">Parool:<input type="password" name="password"></label><br>

                <input class="logInButton" type="submit" value="Logi sisse" name="login">
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

    $('[name="admin_login_form"]').validate({
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