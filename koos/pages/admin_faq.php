<?php 
    require('../head.php');

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

    $sectionHTML = readSectionForSelect();
    $notice = null;

    $question = null;   
    $answer = null;

    $question_error = null;
    $answer_error = null;
    $sectionName_error = null;

    if(isset($_POST["addFAQ"])){
        if(isset($_POST["section-id"]) and !empty($_POST["section-id"])){
            $sectionName_error = null;
        } else {
            $sectionName_error = "Palun vali rubriik!";
        }

        if(isset($_POST["question"]) and !empty($_POST["question"])){
            $question = test_input($_POST["question"]);
        } else {
            $question_error = "Palun sisesta küsimus!";
        }

        if(isset($_POST["answer"]) and !empty($_POST["answer"])){
            $answer = test_input($_POST["answer"]);
        } else {
            $answer_error = "Palun sisesta küsimusele vastus!";
        }

        if(empty($sectionName_error) and empty($question_error) and empty($answer_error)){
            $notice = addFAQ($_POST["section-id"], $question, $answer);
        }
    }

?>
<body>
    <div class="main-flex header">
        <div class="aside"></div>

        <!-- HEADER -->
        <div class="main-section">
            <?php require('../header_admin.php'); ?>
        </div>
        <div class="aside"></div>

    </div><!--.main-flex-->

    <div class="main-flex page-body">
        <div class="aside"></div>

            <div class="main-section">
                <!-- pealkiri  -->
                <div class="flex-row"> 
                    <h1 class="title">KKK LEHE MUUTMINE</h1>
                </div>

                <form class="flex-column" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
        
                <label class="section">Rubriik
                    <select name="section-id">
                        <option disabled selected value>Vali rubriik</option>
                        <?php echo $sectionHTML; ?>
                    </select>
                <p class="star">*</p><span><?php $sectionName_error; ?></span>
                </label>

                <label class="storageLabel">Küsimus
                <textarea name="question" cols="30" rows="5" type="text" value="<?php echo $question; ?>"></textarea>
                <p class="star">*</p> <span><?php echo $question_error; ?></span>
                </label>

                <label class="storageLabel">Vastus
                <textarea name="answer" cols="30" rows="5" type="text" value="<?php echo $answer; ?>"></textarea>
                <p class="star">*</p> <span><?php echo $answer_error; ?></span>
                </label>

                <input name="addFAQ" class="add-ad" type="submit" value="LISA"><span><?php echo $notice; ?></span>
                
                </form>
                <br>
                <hr>

            </div>
        <div class="aside"></div>
    </div>

</body>
</html>