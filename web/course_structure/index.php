<?php
// course structure
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;
use Admin\EdxCourse;

$admin = new AdminLte();
$admin->path("../");
$admin->title("Course");
echo $admin->printPrivate();

//$course_id=@$_GET['course_id'];
$edxapp = new EdxApp();
$edxCourse = new EdxCourse();
?>
<section class="content-header">
    <h1><i class='fa fa-book'></i> Course structure</h1>
</section>


<!-- Main content -->
<section class="content">
<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-lg-6 connectedSortable">
        <?php
        include "box_courses.php";
        //include "box_structure1.php";
        
        $box = new Admin\SolidBox;
        //$box->type("success");
        $box->id("boxStructure");
        $box->icon("fa fa-user");
        $box->title("Structure");
        $box->body("<div id='more'><br /><br /><br /><br /></div>");
        //$box->loading(true);
        echo $box->html();
        ?>
    </section>

    <!-- Right col -->
    <section class="col-lg-6 connectedSortable">

        
    </section>
</div>

<script>
$(function(){
    
    console.log("ready");
    
    $('#course_id').change(function(x){
        console.log(x);
        getStructure();
    });
    getStructure();
});

function getStructure(){
    $('#more').load("ctrl.php",{'do':'get','courseid':$('#course_id').val()},function(x){
        //
    });
}


</script>