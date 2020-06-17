<?php 
    require('../head.php');

    $adminLinkValue=2;
    $searchedArea=null;
    $searchedName=null;
    $searchedCategory=null;
    $offset=0;
    $notice=null;
    $sentElement=null;
    $searchedStorageID=null;
    $case = 0;

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

    foundToExpired();
    if(isset($_POST["deleteAd"])){
        $id = $_POST["idInput"];
        $case = deleteFoundAdmin($id);
        $notice;
    }
?>
<body>


<?php require('../header_admin.php'); ?>


<div class="main-flex page-body">
    <div class="aside"></div>


    <div class="main-section">

        <!-- HERO TEXT  -->
        <div class="flex-row"> 
            <h1 class="title">LEITUD ESEMED</h1>
        </div>

        <div class="flex-row"> 
            <a class="add-ad" href="new_found.php">LISA ESE</a>
        </div>
        <div class="clearfix-50">
        </div>
        <!-- PAGE BODY -->

        <div class="filtersProductsLayout"> 

            <?php require("../admin_filter.php") ?>
            <div class="products">
            <?php
                        if ($notice==100) {
                            $notice = '<p class="flex-row">Hetkel esemeid pole!</p>';
                        }
                    
                     echo selectFoundPostsAdmin($offset,$searchedName,$sentElement, $searchedStorageID,$searchedArea,$adminLinkValue); ?>
            </div><!--.products -->
        </div><!--.flex-row-->
        <div class="js-more-wrapper loadMoreButton"><button data-inf=0 data-type=2 class="js-load-more" data-atype=1>lae juurde</button></div>
    </div><!--.main-section-->
    

    <div class="aside"></div>
</div>

<input class="modalCase" type="hidden" data-case="<?php echo $case;?>">
<?php 

$url = "#";
$urlTitle = '';
require('../pages/modal.php'); ?>


<script>

    $(document).on('click', '[name="deleteAd"]', function(e) {
        var answer = confirm("Olete kindel, et kustutada?");
        if(answer == true){
            //alert('navigate!');
            // reload page
            console.log("yes");
        }else{
            e.preventDefault();
        }
    });


</script>
<script src="../js/found.js"></script>
<script src="../js/infiniteScroll.js"></script>
</body>
</html>