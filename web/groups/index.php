<?php
//admin :: groups
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

//use Admin\AdminLte;

$admin = new Admin\AdminLte();
$edxApp= new Admin\EdxApp();

echo $admin->printPrivate();


// group counts
$sql="SELECT group_id, COUNT(user_id) as c FROM edxapp.auth_user_groups GROUP BY group_id;";
$q = $admin->db()->query($sql) or die("admin->db()->error");
$GC=[];
while ($r=$q->fetch(PDO::FETCH_ASSOC)) {
    $GC[$r['group_id']]=$r['c'];
}
// print_r($GC);

?>


<section class="content-header">
    <h1><i class="fa fa-book"></i> Groups <small>Group info</small></h1>
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
    $box->title("Title");
    
    $htm=[];
    $htm[]="<div class='form-group'>";
    $htm[]='<label>Group type</label>';
    $htm[]="<select class='form-control'>";
    $htm[]="<option>Select group type</option>";
    $htm[]="<option value='beta_testers'>beta_testers</option>";
    $htm[]="<option value='instructor'>instructor</option>";
    $htm[]="<option value='staff'>staff</option>";
    $htm[]="</select>";
    $htm[]="</div>";

    echo $box->html($htm);

    // auth_group
    $sql = "SELECT * FROM edxapp.auth_group ORDER BY id DESC;";
    $q = $admin->db()->query($sql) or die("admin->db()->error");
    
    $htm=[];
    $htm[]= "<table class='table table-condensed table-striped'>";
    $htm[]= "<thead>";
    $htm[]= "<th>#</th>";
    $htm[]= "<th>Type</th>";
    $htm[]= "<th>Group name</th>";
    $htm[]= "<th>Course</th>";
    $htm[]= "</thead>";

    while ($r=$q->fetch(PDO::FETCH_ASSOC)) {
        //print_r($r);
        $htm[]= "<tr>";
        $htm[]= "<td><a href='../group/?id=".$r['id']."'>".$r['id']."</a>";
        $htm[]= "<td>".explode("_", $r['name'])[0];
        $htm[]= "<td>".$r['name'];
        $coursename=preg_replace('/^(beta_testers|instructor|staff)_/', '', $r['name']);
        $coursename=str_replace('.', '/', $coursename);
        $htm[]= "<td><a href='../course/?id=$coursename'>".$coursename;

    }
    $htm[]= "</table>";

    $box=new Admin\SolidBox;
    $box->title("Groups");
    echo $box->html($htm);

    ?>
    </section>

</div>

<script>
$(function(){
    $("table").tablesorter();
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
