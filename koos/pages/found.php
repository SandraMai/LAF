<?php require('../head.php'); ?>
<body>


<div class="main-flex header">
    <div class="aside"></div>

    <!-- HEADER -->
    <div class="main-section">
        <?php require('../header.php'); ?>
    </div>
    <div class="aside"></div>

</div>

<div class="main-flex">
    <div class="aside"></div>


    <div class="main-section">

        <!-- HERO TEXT  -->
        <div class="flex-row"> 
            <h1 class="title">LEITUD ESEMED</h1>
        </div>

        <!-- HERO BUTTON  -->
        <div class="flex-row"> 
            <a class="add-ad" href="new_found.php">LISA ESE</a>
        </div>

        <!-- PAGE NUMBERS -->
        <div class="flex-row"> 
            <div class="aside"></div>
            <div>1 2 3 </div>
        </div>


        <!-- PAGE BODY -->
        <div class="flex-row"> 

            <div class="filters">
                <h2 class="flex-column">FILTERS</h2>
                <ul class="ul flex-column">
                    <li>RIIDED</li>
                    <li>TEHNIKA</li>
                    <li>MUU</li>
                </ul>
            </div>
            
            <div class="products">

                <?php //echo selectFoundPostsHTML();?>
                

            </div><!--.products -->

        </div><!--.flex-row-->



    </div>



    <div class="aside"></div>
</div>




<script src="../js/found.js"></script>
</body>
</html>