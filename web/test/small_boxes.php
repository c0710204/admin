<div class="row">
<?php
// small boxes demo
// http://almsaeedstudio.com/AdminLTE/pages/widgets.html
?>
</div>
<h1>Small boxes</h1>
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <?php
        //$smallbox= new SmallBox;
        $smallbox->color('red');
        $smallbox->icon("fa fa-users");
        $smallbox->title('Random percentage');
        $smallbox->value(rand(0, 100).'%');
        $smallbox->link("<a href=#>Yo !</a>");
        echo $smallbox->html();
        ?>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <?php
        $smallbox->color('green');
        $smallbox->icon("fa fa-dashboard");
        $smallbox->title('Randomness');
        $smallbox->value(rand(0, 100).'%');
        $smallbox->link("");
        echo $smallbox->html();
        ?>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <?php
        $smallbox->color('yellow');
        $smallbox->icon("fa fa-bank");
        $smallbox->title('Randomness');
        $smallbox->value(rand(0, 100).'%');
        $smallbox->link("");
        echo $smallbox->html();
        ?>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <?php
        $smallbox->color('blue');
        $smallbox->icon("fa fa-list");
        $smallbox->title('Randomness');
        $smallbox->value(rand(0, 100).'%');
        $smallbox->link("");
        echo $smallbox->html();
        ?>
    </div><!-- ./col -->
</div>