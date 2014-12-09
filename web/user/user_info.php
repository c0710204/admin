<?php 
exit;// unused
?>
<div class="box box-primary">

    <div class="box-header">
        <h3 class="box-title">Django User info</h3>

        <div class="pull-right box-tools">
            <button class="btn btn-primary btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-primary btn-sm" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove"><i class="fa fa-times"></i></button>
        </div>

        </div><!-- /.box-header -->

    <!-- form start -->
    <form role="form">

        <div class="box-body">


        <div class="form-group">
            <label for="exampleInputEmail1">Username</label>
            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Username" value="<?php echo $usr['username']?>">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">First name</label>
            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="First name" value="<?php echo $usr['first_name']?>">
        </div>

        <div class="form-group">
            <label>Last name</label>
            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Last name" value="<?php echo $usr['last_name']?>">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" value="<?php echo $usr['email']?>">
        </div>

        <div class="form-group">
            <label>Last login</label>
            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Last login" value="<?php echo $usr['last_login']?>">
        </div>

        <div class="form-group">
            <label>Date joined</label>
            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Date joined" value="<?php echo $usr['date_joined']?>">
        </div>


        </div><!-- /.box-body -->

    </form>
</div>