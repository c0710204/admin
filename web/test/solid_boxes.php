<?php
// Solid boxes
?>
<h1>Solid Boxes</h1>
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <?php
        $solidbox = new Admin\SolidBox;
        //$solidbox->icon('fa fa-users');
        $solidbox->title('Solidbox title');
        $solidbox->removable(false);
        $solidbox->body('Qu est ce qui est jaune et qui est dans un sous marin et qui sent pas bon ?<br />Alors ? Tu sais pas ?');
        $solidbox->footer('<a href=# class="btn btn-default">Ok</a>');
        echo $solidbox->html();
        ?>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <?php
        $solidbox = new Admin\SolidBox;
        $solidbox->icon('fa fa-users');
        $solidbox->type('warning');
        $solidbox->title('Solidbox Warning');
        $solidbox->removable(true);
        $solidbox->body('Qu est ce qui est jaune et qui est dans un sous marin et qui sent pas bon ?<br />Alors ? Tu sais pas ?');
        $solidbox->footer('<a href=# class="btn btn-default">Alors ? Tu sais pas ?</a>');
        echo $solidbox->html();
        ?>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <?php
        $solidbox = new Admin\SolidBox;
        $solidbox->icon('fa fa-users');
        $solidbox->type('info');
        $solidbox->title('Solidbox Info');
        //$solidbox->removable(true);
        $solidbox->body('Qu est ce qui est jaune et qui est dans un sous marin et qui sent pas bon ?<br />Alors ? Tu sais pas ?');
        echo $solidbox->html();
        ?>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <?php
        //work on gradient here
        ?>
    </div><!-- ./col -->
</div>