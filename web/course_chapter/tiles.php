<?php
// tiles.php
?>
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <?php
        $smallbox= new Admin\SmallBox;
        $smallbox->color('blue');
        $smallbox->icon("ion ion-person-add");
        
        $smallbox->value('10');
        $smallbox->title('New users');
        $smallbox->url('../users');
        echo $smallbox->html();
        ?>
    </div><!-- ./col -->

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <?php
        $smallbox= new Admin\SmallBox;
        $smallbox->color('red');
        $smallbox->icon("fa fa-book");
        $smallbox->value('12');
        $smallbox->title('Courses');
        $smallbox->url("../courses");
        echo $smallbox->html();
        ?>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <?php
        $smallbox= new Admin\SmallBox;
        $smallbox->color('green');
        $smallbox->icon("fa fa-comments-o");
        $smallbox->value(rand(2, 20));
        $smallbox->title('Forum threads');
        $smallbox->url("../forum");
        echo $smallbox->html();
        ?>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <?php
        $smallbox= new Admin\SmallBox;
        $smallbox->color('yellow');
        $smallbox->icon("fa fa-bank");
        $smallbox->title('Randomness');
        $smallbox->value(rand(0, 100).'%');
        //$smallbox->url("");
        echo $smallbox->html();
        ?>
    </div><!-- ./col -->

</div>