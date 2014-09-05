<?php
//admin :: new course
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;
use Admin\EdxCourse;

$admin = new AdminLte();
$admin->path("../");
$admin->title("Courses");

echo $admin->printPrivate();
//$edxapp= new EdxApp("../config.json");
//$edxCourse= new EdxCourse("../config.json");
?>

<section class="content-header">
    <h1><i class="fa fa-book"></i> New Course</h1>
</section>

<!-- Main content -->
<section class="content">


<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-lg-6 connectedSortable">
    <?php
    // new course

    $body=[];

    // org
    $body[]='<div class="form-group">';
    $body[]='<label>Org</label>';
    $body[]='<input type="text" class="form-control" id="org">';
    $body[]='</div>';

    // course
    $body[]='<div class="form-group">';
    $body[]='<label>Course</label>';
    $body[]='<input type="text" class="form-control" id="course">';
    $body[]='</div>';

    // display name
    $body[]='<div class="form-group">';
    $body[]='<label>Name</label>';
    $body[]='<input type="text" class="form-control" id="name">';
    $body[]='</div>';


    $foot=[];
    $foot[]="<button class='btn' onclick=newCourse()><i class='fa fa-save'></i> Save</button>";
    $foot[]="<a class='btn btn-primary pull-right' href='index.php'><i class='fa fa-cancel'></i> Cancel</a>";

    echo $admin->box("danger", "New course", $body, $foot);

    ?>
    </section>

    <section class="col-lg-6 connectedSortable">
    Col.B
    </section>
</div>

<div id='more'></div>

<script>
$(function(){
    console.log("ready");
    $('#org').change(function(x){
        //try{ eval(x); }
        //catch(e){ alert(e); }
        console.log('org change');
    });
});

function newCourse(){

    if(!$('#org').val())return false;
    if(!$('#course').val())return false;
    if(!$('#name').val())return false;

    var p={
        'do':'newCourse',
        'org':$('#org').val(),
        'course':$('#course').val(),
        'name':$('#name').val()
    };

    $('#more').load('ctrl.php',p,function(x){

    });
}

</script>