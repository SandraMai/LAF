<?php 

require('../head.php'); 
 

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

        <div class="flex-column faq"> 
            <h1 class="title">LEITUD</h1>
                <?php 
                    echo getFAQSection(1);         
                ?>
        
            <h1 class="title">KAOTATUD</h1>
                <?php
                    echo getFAQSection(2);
                ?>
            <h1 class="title">OKSJON</h1>
                <?php
                    echo getFAQSection(3);
                ?>
            <h1 class="title">MUU</h1>
                <?php
                    echo getFAQSection(4);
                ?>
        </div>
    </div>
    <div class="aside"></div>
</div>
</body>