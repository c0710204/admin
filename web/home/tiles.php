<?php
// tiles.php
?>
<div class="row">
    <div class="col-sm-3 col-xs-6">
        <!-- small box users -->
        <?php
        $sql="SELECT COUNT(*) as count FROM edxapp.auth_user WHERE 1;";
        $q=$admin->db()->query($sql) or die($admin->db()->errorInfo()[2]."<hr />$sql");
        $r=$q->fetch(\PDO::FETCH_ASSOC);

        $smallbox= new Admin\SmallBox;
        $smallbox->color('blue');
        $smallbox->icon("ion ion-person-add");
        
        $smallbox->value(number_format($r['count']));
        $smallbox->title('Users');
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
        $smallbox->value(count($edxapp->courseids()));
        $smallbox->title('Courses');
        $smallbox->url("../courses");
        echo $smallbox->html();
        ?>
    </div><!-- ./col -->
    <div class="col-sm-3 col-xs-6">
        <!-- small box forum-->
        <?php

        $n=$forum->threads()->count();
        //$n=$contents->count();
        $smallbox= new Admin\SmallBox;
        $smallbox->color('green');
        $smallbox->icon("fa fa-comments-o");
        $smallbox->value($n);
        $smallbox->title('Forum thread(s)');
        $smallbox->url("../forum");
        echo $smallbox->html();
        ?>
    </div><!-- ./col -->
    <div class="col-sm-3 col-xs-6">
        <!-- small box -->
        <?php
        // org
        $smallbox= new Admin\SmallBox;
        $smallbox->color('yellow');
        $smallbox->icon("fa fa-bank");
        $smallbox->title('Org(s)');
        $smallbox->value(count($edxapp->orgs()));
        //$smallbox->url("");
        echo $smallbox->html();
        ?>
    </div><!-- ./col -->

</div>