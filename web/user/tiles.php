<?php
// User tiles
?>
<div class="row">
    
    <div class="col-sm-3 col-xs-6">
        <!-- small box users -->
        <?php
        //$user_sessions=@$edxApp->sessions([$USERID])[$USERID];
        $smallbox= new Admin\SmallBox;
        $smallbox->id('tileSession');
        $smallbox->color('blue');
        $smallbox->icon("ion ion-person-add");
        $smallbox->value(0);
        $smallbox->title('Sessions');
        $smallbox->url('../users');
        echo $smallbox->html();
        ?>
    </div><!-- ./col -->

    <div class="col-sm-3 col-xs-6">
        <!-- small box courses -->
        <?php
        //$courses=$edxApp->studentCourseEnrollment($USERID);
        $smallbox= new Admin\SmallBox;
        $smallbox->id('tileEnroll');
        $smallbox->color('red');
        $smallbox->icon("fa fa-book");
        $smallbox->value(0);
        $smallbox->title('Course enrollment(s)');
        $smallbox->url("../courses");
        echo $smallbox->html();
        ?>
    </div><!-- ./col -->
    <div class="col-sm-3 col-xs-6">
        <!-- small box forum-->
        <?php
        $postCount=$edxForum->postCount($USERID);
        $smallbox= new Admin\SmallBox;
        $smallbox->color('green');
        $smallbox->icon("fa fa-comments-o");
        $smallbox->value($postCount);
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
        $smallbox->title('(s)');
        $smallbox->value(0);
        //$smallbox->url("");
        echo $smallbox->html();
        ?>
    </div><!-- ./col -->

</div>