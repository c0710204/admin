<?php
//admin :: groups
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

$admin = new Admin\AdminLte();
$edxApp= new Admin\EdxApp();
$edxCourse= new Admin\EdxCourse();

echo $admin->printPrivate();
?>

<section class="content-header">
    <h1><i class="fa fa-users"></i> Groups <small>Group info</small></h1>
</section>

<!-- Main content -->
<section class="content">

<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-lg-12 connectedSortable">
    <?php
    $box=new Admin\SolidBox;
    $box->icon("fa fa-search");
    $box->title("Group filter");
    $box->type("danger");
    
    $htm=[];

    $htm[]="<div class='row'>";//

    // org
    $htm[]="<div class='col-lg-2'>";
    $htm[]="<div class='form-group'>";
    $htm[]="<label>Org</label>";
    $htm[]="<select class='form-control' id='org'>";

    $list=$edxApp->orgs();
    
    if (count($list)==1) {
        $htm[]="<option value='".$list[0]."'>".$list[0]."</option>";
    } else {
        $htm[]="<option value=''>Any</option>";
        foreach ($list as $org) {
            $selected='';
            $htm[]="<option value='$org' $selected>$org</option>";
        }
    }

    $htm[]="</select>";
    $htm[]="</div></div>";



    // type
    $htm[]="<div class='col-lg-2'>";
    $htm[]="<div class='form-group'>";
    $htm[]='<label>Group type</label>';
    $htm[]="<select class='form-control' id='grouptype'>";
    $htm[]="<option value=''>Any</option>";
    $htm[]="<option value='beta_testers'>beta_testers</option>";
    $htm[]="<option value='instructor'>instructor</option>";
    $htm[]="<option value='staff'>staff</option>";
    $htm[]="</select>";
    $htm[]="</div>";
    $htm[]="</div>";
 


    // str
    $htm[]="<div class='col-lg-4'>";
    $htm[]="<div class='form-group'>";
    $htm[]="<label>Search</label>";
    $htm[]="<input type=text class=form-control id='searchStr' placeholder='Group name'>";
    $htm[]="</div></div>";

   
    $htm[]="</div>";// row

    echo $box->html($htm);




    // group list
    $box=new Admin\SolidBox;
    $box->title("Groups");
    $box->id("grouplist");
    $box->icon("fa fa-list");
    $box->loading(true);
    echo $box->html("groups");

    ?>
    </section>

</div>

<div id='more'></div>

<script src='groups.js'></script>


<?php

// auth_group_permissions
// auth_user_groups


// course_groups_courseusergroup
// course_groups_courseusergroup_users
// paid_group


// student_usertestgroup
// student_usertestgroup_users


// waffle_flag_groups


/*

    // auth_group
    $sql = "SELECT * FROM edxapp.auth_group ORDER BY id DESC;";
    $q = $admin->db()->query($sql) or die("admin->db()->error");
    
    $htm=[];
    $htm[]= "<table class='table table-condensed table-striped'>";
    $htm[]= "<thead>";
    $htm[]= "<th>#</th>";
    $htm[]= "<th>Type</th>";
    $htm[]= "<th>Group name</th>";
    $htm[]= "<th>Users</th>";
    $htm[]= "<th>Course</th>";
    $htm[]= "</thead>";

    while ($r=$q->fetch(PDO::FETCH_ASSOC)) {
        //print_r($r);
        $htm[]= "<tr>";
        $htm[]= "<td><a href='../group/?id=".$r['id']."'>".$r['id']."</a>";
        $htm[]= "<td>".explode("_", $r['name'])[0];
        $htm[]= "<td>".$r['name'];
        $htm[]= "<td>".$GC[$r['id']];

        $course_id=preg_replace('/^(beta_testers|instructor|staff)_/', '', $r['name']);
        $course_id=str_replace('.', '/', $course_id);
        
        if (!$edxCourse->exist($course_id)) {
            $htm[]="<td><b>Not found</b>";
        } else {
            $htm[]= "<td><a href='../course/?id=$course_id'>".$course_id;
        }

    }
    $htm[]= "</table>";

    */
   

