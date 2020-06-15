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

    $questionHTML = getFaqQuestions();
    $answerHTML = getFaqAnswers();

    $notice = null;
    $noticeQuestion = null;
    $noticeAnswer = null;

    $newquestion = null;   
    $newanswer = null;
    $question = null;
    $answer = null;

    $question_error = null;
    $answer_error = null;
    $sectionName_error = null;

    //KKK lisamine
    if(isset($_POST["addFAQ"])){
        if(isset($_POST["section-id"]) and !empty($_POST["section-id"])){
            $sectionName_error = null;
        } else {
            $sectionName_error = "Palun vali rubriik!";
        }

        if(isset($_POST["newquestion"]) and !empty($_POST["newquestion"])){
            $newquestion = test_input($_POST["newquestion"]);
        } else {
            $question_error = "Palun sisesta küsimus!";
        }

        if(isset($_POST["newanswer"]) and !empty($_POST["newanswer"])){
            $newanswer = test_input($_POST["newanswer"]);
        } else {
            $answer_error = "Palun sisesta küsimusele vastus!";
        }

        if(empty($sectionName_error) and empty($question_error) and empty($answer_error)){
            $notice = addFAQ($_POST["section-id"], $newquestion, $newanswer);
        }
    }
    //küsimuse uuendamine
    if(isset($_POST["updateQuestion"])){
        $noticeQuestion = updateFaqQuestion($_POST["question-id"], $_POST["question"]);
    }
    //vastuse uuendamine
    if(isset($_POST["updateAnswer"])){
        $noticeAnswer = updateFaqAnswer($_POST["answer-id"], $_POST["answer"]);
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
                    <h1 class="title">KKK LISAMINE</h1>
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
                <textarea name="newquestion" cols="30" rows="5" type="text" value="<?php echo $newquestion; ?>"></textarea>
                <p class="star">*</p> <span><?php echo $question_error; ?></span>
                </label>

                <label class="storageLabel">Vastus
                <textarea name="newanswer" cols="30" rows="5" type="text" value="<?php echo $newanswer; ?>"></textarea>
                <p class="star">*</p> <span><?php echo $answer_error; ?></span>
                </label>

                <input name="addFAQ" class="add-ad" type="submit" value="LISA"><span><?php echo $notice; ?></span>
                
                </form>
                <br>
                <hr>
                <div class="flex-row"> 
                    <h1 class="title">KKK LEHE MUUTMINE</h1>
                </div>

                <form class="flex-column" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
        
                <select name="question-id">
                    <option disabled selected value>Vali küsimus</option>
                    <?php echo $questionHTML; ?>
                </select>
                <br>
                <label class="storageLabel">Küsimus
                <textarea name="question" cols="30" rows="5" type="text" placeholder="Uuendatud küsimus..."></textarea>
                </label>

                <input name="updateQuestion" class="add-ad" type="submit" value="UUENDA"><span><?php echo $noticeQuestion; ?></span>
                </form>

                <br>                
                
                <form class="flex-column" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">

                <select name="answer-id">
                    <option disabled selected value>Vali vastus</option>
                    <?php echo $answerHTML; ?>
                </select>
                <br>
                <label class="storageLabel">Vastus
                <textarea name="answer" cols="30" rows="5" type="text" placeholder="Uuendatud vastus..."></textarea>
                </label>
                <br>

                <input name="updateAnswer" class="add-ad" type="submit" value="UUENDA"><span><?php echo $noticeAnswer; ?></span>
                </form>
            </div>
        <div class="aside"></div>
    </div>

</body>
</html>