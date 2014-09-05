<?php
// backup/tiles.php
$q=$admin->db()->query("SHOW TABLE STATUS FROM edxapp;") or die("mysql error");
$tableCount=$q->rowCount();
$records=0;
while ($r=$q->fetch(PDO::FETCH_ASSOC)) {
    $records+=$r['Rows'];
}
?>
<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <?php
    $smallbox= new Admin\SmallBox;
    $smallbox->color('red');
    $smallbox->icon("fa fa-database");
    $smallbox->value($tableCount);
    $smallbox->title('Mysql tables');
    //$smallbox->url('../users');
    echo $smallbox->html();
    ?>
</div><!-- ./col -->

<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <?php
    $smallbox= new Admin\SmallBox;
    $smallbox->color('red');
    $smallbox->icon("fa fa-database");
    $smallbox->value(number_format($records));
    $smallbox->title('Mysql records');
    //$smallbox->url("../courses");
    echo $smallbox->html();
    ?>
</div><!-- ./col -->
<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <?php
    $smallbox= new Admin\SmallBox;
    $smallbox->color('yellow');
    $smallbox->icon("fa fa-database");
    $smallbox->value(0);
    $smallbox->title('Mongo');
    //$smallbox->url("../forum");
    echo $smallbox->html();
    ?>
</div><!-- ./col -->
<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <?php
    $smallbox= new Admin\SmallBox;
    $smallbox->color('yellow');
    $smallbox->icon("fa fa-database");
    $smallbox->title('Mongo');
    $smallbox->value(0);
    //$smallbox->url("");
    echo $smallbox->html();
    ?>
</div><!-- ./col -->
