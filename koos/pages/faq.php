<?php 

require('../head.php'); 
$faqHTML = getFAQ();

?>
<body>
<div class="main-flex header">
    <div class="aside"></div>

    <!-- HEADER -->
        <div class="main-section">
            <?php require('../header.php'); ?>
        </div>
    <div class="aside"></div>
</div>

<div class="main-flex page-body">
<div class="aside"></div>
    <div class="main-section">

        <div class="flex-row"> 
            <h1 class="title">KORDUMA KIPPUVAD KÜSIMUSED</h1>
        </div>

        <div class="flex-row"> 
            <?php echo $faqHTML ?>
        </div>
    </div>
    <div class="aside"></div>
</div>
</body>