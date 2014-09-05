<?php
// tiles demo
?>
<h1>Tiles</h1>
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <?php
        $tile = new Admin\Tile;
        $tile->color('navy');
        $tile->icon('fa fa-users');
        $tile->title('Lorem tile title');
        $tile->body('Tralalalal lorem lipsum<br />Qu est ce qui est jaune et qui est dans un sous marin et qui sent pas bon<br />tile');
        echo $tile->html();
        ?>
    </div><!-- ./col -->

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <?php
        $tile = new Admin\Tile;
        $tile->color('green');
        $tile->icon('fa fa-dashboard');
        $tile->title('Lorem tile title');
        $tile->body('Tralalalal lorem lipsum<br />tile tile tile tile tile tile til<br />tile tile tile ');
        echo $tile->html();
        ?>
    </div><!-- ./col -->

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <?php
        $tile = new Admin\Tile;
        $tile->color('red');
        $tile->icon('fa fa-users');
        $tile->title('Lorem tile title');
        $tile->body('Tralalalal lorem lipsum<br />tile');
        $tile->removable(true);
        echo $tile->html();
        ?>
    </div><!-- ./col -->

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <?php
        $tile = new Admin\Tile;
        $tile->color('yellow');
        $tile->icon('fa fa-users');
        $tile->title('Lorem tile title');
        $tile->body('Tralalalal lorem lipsum<br />tile');
        echo $tile->html();
        ?>
    </div><!-- ./col -->
</div>