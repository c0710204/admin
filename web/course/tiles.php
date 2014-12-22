<?php
// Course tiles
?>
<div class="row">
    <div class="col-sm-3 col-xs-6">
        <!-- small box users -->
        <?php

        $smallbox= new Admin\SmallBox;
        $smallbox->color('blue');
        $smallbox->icon("ion ion-person-add");
        $smallbox->value(6);
        $smallbox->title('Chapters');
        $smallbox->url('../users');
        echo $smallbox->html();
        ?>
    </div><!-- ./col -->

    <div class="col-sm-3 col-xs-6">
        <!-- small box courses -->
        <?php
        $smallbox= new Admin\SmallBox;
        $smallbox->color('red');
        $smallbox->icon("fa fa-book");
        $smallbox->value(133);
        $smallbox->title('Course enrollmentss');
        $smallbox->url("../courses");
        echo $smallbox->html();
        ?>
    </div><!-- ./col -->
    <div class="col-sm-3 col-xs-6">
        <!-- small box forum-->
        <?php
        $smallbox= new Admin\SmallBox;
        $smallbox->color('green');
        $smallbox->icon("fa fa-comments-o");
        $smallbox->value(33);
        $smallbox->title('Forum post');
        $smallbox->url("../forum");
        echo $smallbox->html();
        ?>
    </div><!-- ./col -->
    <div class="col-sm-3 col-xs-6">
        <!-- small box -->
        <?php
        // other
        $smallbox= new Admin\SmallBox;
        $smallbox->color('yellow');
        $smallbox->icon("fa fa-bank");
        $smallbox->title('Banana(s)');
        $smallbox->value(12);
        //$smallbox->url("");
        echo $smallbox->html();
        ?>
    </div><!-- ./col -->

</div>