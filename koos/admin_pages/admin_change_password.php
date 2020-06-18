<?php 

    $pageTitle="LAF admin. Muuda parooli";
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

    $notice = null;
    $areEqual = null;
    $case = 0;


    if(isset($_POST["submitNewPassword"])){

        $password1 = validateMinMaxLength(cleanTextInput('new_password'));
        $password2 = validateMinMaxLength(cleanTextInput('new_password_again'));
        $areEqual = areEqual($password1, $password2);




        if($password1 && $password2 && $areEqual){
            $notice = updatePassword($_POST["new_password"]);
            if($notice == 2) {
                $case = 6;
            } elseif ($notice == 404) {
                $case = 10;
            }
        }        
    }

    if(isset($_POST["cancel"])){
        header("Location: admin_settings.php");
        exit();
    }

   

?>
<body>

<?php require('../header_admin.php'); ?>


    <div class="main-flex page-body">
        <div class="aside"></div>

            <div class="main-section">
                <!-- pealkiri  -->
                <div class="flex-row"> 
                    <h1 class="title">PAROOL</h1>
                </div>

                <div class="flex-column">
                    <form class="password-box flex-column" name="admin_change_password_form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
            

                    <div class="error-new_password"></div>
                    <label>Uus parool</label>
                    <input name="new_password" class="password-input" type="password">                   
                    <br>

                    <div class="error-new_password_again"></div>
                    <label>Uus parool uuesti</label>
                    <input name="new_password_again" class="password-input" type="password">
                    <br>
                    <p class="star">Jaga töötajatele uut parooli!</p>
                    <input name="submitNewPassword" class="password-button" type="submit" value="MUUDA PAROOLI"> <span></span>
                </form>

                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
                  <input name="cancel" class="password-button" type="submit" value="TÜHISTA">  
                </form>

                </div>
                
            </div>
        <div class="aside"></div>
    </div>

<input class="modalCase" type="hidden" data-case="<?php echo $case;?>">
<?php 

$url = "admin_settings.php";
$urlTitle = 'Tagasi seadetesse';
require('../pages/modal.php'); ?>



<script>
$(document).ready(function() {


    // Only letters, numbers, or dashes allowed
    $.validator.addMethod("aznumeric", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9]*$/i.test(value);
    });

    $('[name="admin_change_password_form"]').validate({
        rules: {
            new_password : {
                required: true,
                aznumeric: true,
                minlength: 8,
                maxlength: 30
            },
            new_password_again : {
                required: true,
                aznumeric: true,
                minlength: 8,
                maxlength: 30,
                equalTo: '[name="new_password"]'
            }
        },
        messages: {
            new_password: {
                required: "Palun sisestage kasutajatunnus.",
                aznumeric: "Lubatud on ainult numbrid ja tähed",
                minlength: "Palun sisestage vähemalt 8 karakterit",
                maxlength: "Palun sisestage maksimaalselt 30 karakterit"
            },
            new_password_again: {
                required: "Palun sisestage parool.",
                aznumeric: "Lubatud on ainult numbrid ja tähed",
                minlength: "Palun sisestage vähemalt 8 karakterit",
                maxlength: "Palun sisestage maksimaalselt 30 karakterit",
                equalTo: "Paroolid peavad kattuma"
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