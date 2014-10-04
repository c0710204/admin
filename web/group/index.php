<?php
// admin :: group
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";


$admin = new Admin\AdminLte();
$edxApp= new Admin\EdxApp();
$edxCourse= new Admin\EdxCourse();

echo $admin->printPrivate();

$group_id=@$_GET['id']*1;

?>

<section class="content-header">
    <h1><i class="fa fa-users"></i> Group <small>Group info</small></h1>
</section>

<!-- Main content -->
<section class="content">

<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-sm-6 connectedSortable">
    <input type=hidden id='group_id' value='<?php echo $group_id?>'>
    <?php
    include "group_info.php";
    include "group_help.php";
    ?>
    <div id='more'></div>
    </section>


    <!-- col -->
    <section class="col-sm-6 connectedSortable">
    <?php
    include "group_users.php";
    ?>
    </section>


</div>

<script>
$(function(){
    $("table").tablesorter();
    $("#btndel").click(function(){
        if(!confirm("Delete this group ?"))return false;
        var p={
            'do':'delete',
            'group_id':$('#group_id').val()
        };
        
        $("#box-info .box-footer").load("ctrl.php",p,function(x){
            try{eval(x);}
            catch(e){alert(x);}
        });
    });

});
</script>


<?php

// auth_group_permissions
// auth_user_groups


// course_groups_courseusergroup
// course_groups_courseusergroup_users
// paid_group


// student_usertestgroup
// student_usertestgroup_users


// waffle_flag_groups
