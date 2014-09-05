<?php
//admin :: list users
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

//use Admin\Curl;
use Admin\AdminLte;
use Admin\EdxApp;

$admin = new AdminLte("../config.json");
$admin->path("../");

$edx = new EdxApp("../config.json");

echo $admin->printPrivate();

$USERID=$_GET['id']*1;

$usr=$edx->user($USERID);
$up =$edx->userprofile($USERID);
//print_r($usr);
//print_r($up);

?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        User #<?php echo $USERID?>
        <small>user details</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">




<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-lg-6 connectedSortable">


<!-- Userinfo -->
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

    </section>
    <section class="col-lg-6 connectedSortable">

<!-- Userprofile -->
<div class="box box-primary">

    <div class="box-header">
        <h3 class="box-title">User profile</h3>

        <div class="pull-right box-tools">
            <button class="btn btn-primary btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-primary btn-sm" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove"><i class="fa fa-times"></i></button>
        </div>

        </div><!-- /.box-header -->

    <!-- form start -->
    <form role="form">

        <div class="box-body">

        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" id="name" placeholder="Name" value="<?php echo $up['name']?>">
        </div>

        <div class="form-group">
            <label>Language</label>
            <input type="text" class="form-control" id="language" placeholder="Language" value="<?php echo $up['language']?>">
        </div>

        <div class="form-group">
            <label>Location</label>
            <input type="text" class="form-control" id="location" placeholder="Location" value="<?php echo $up['location']?>">
        </div>

        <div class="form-group">
            <label>Gender</label>
            <input type="email" class="form-control" id="gender" placeholder="Gender" value="<?php echo $up['gender']?>">
        </div>

        <div class="form-group">
            <label>Mailing address</label>
            <input type="text" class="form-control" id="address" placeholder="Mailing address" value="<?php echo $up['mailing_address']?>">
        </div>

        <div class="form-group">
            <label>Year of birth</label>
            <input type="text" class="form-control" id="year_of_birth" placeholder="Year of birth" value="<?php echo $up['year_of_birth']?>">
        </div>

        <div class="form-group">
            <label>Level of education</label>
            <input type="text" class="form-control" id="level_of_education" placeholder="Level of education" value="<?php echo $up['level_of_education']?>">
        </div>


        </div><!-- /.box-body -->

    </form>
</div>

    </section><!-- /.Col -->

</div>



<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-lg-6 connectedSortable">
    <h1>Courses</h1>
    </section><!-- /.Left col -->

    <!-- Col -->
    <section class="col-lg-6 connectedSortable">
    <h1>Certificates</h1>
    </section><!-- /.Col -->

</div>

<?php
/*
echo "<h1>groups</h1>";
$groups=$edx->user_groups($_GET['id']);
echo "groups: ";
print_r($groups);
*/

/*
foreach($groups as $k->$v){
    echo $v['id'];
    echo $edx->groupName($v['id']);
    echo "<br />";
}
*/

// student_courseenrollment
/*
echo "<h1>student_courseenrollment</h1>";
$sql = "SELECT * FROM edxapp.student_courseenrollment WHERE user_id=$user_id;";
$dat=$admin->db->query($sql);

while ($r=$dat->fetch(\PDO::FETCH_ASSOC)) {
    print_r($r);
}
*/

//echo $admin->box("primary", "titre", "blablablabl");
?>

<?php
// Courseware Progress Data
// // http://edx.readthedocs.org/projects/devdata/en/latest/internal_data_formats/sql_schema.html#courseware-progress-data
//echo "<h1>Courseware Progress Data</h1>";
// courseware_studentmodule


// certificates
//echo "<h1>certificates_generatedcertificate</h1>";
//certificates_generatedcertificate

?>
<script>
$(function(){
    console.log("ready");
})
</script>
