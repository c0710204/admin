<?php
//admin :: course enrollments
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
//use Admin\EdxApp;
//use Admin\EdxCourse;

$admin = new AdminLte();
$admin->title("Course enrollments");
echo $admin->printPrivate();

if (isset($_GET['course_id'])) {
    $course_id=@$_GET['course_id'];
} elseif (isset($_GET['id'])) {
    $course_id=@$_GET['id'];
} else {
    die("Error");
}

$edxapp = new Admin\EdxApp();
$edxCourse = new Admin\EdxCourse($course_id);

echo "<input type='hidden' id='course_id' value='$course_id'>";
?>

<section class="content-header">
    <h1><i class='fa fa-user'></i> <i class='fa fa-angle-right'></i> <i class='fa fa-book'></i> 
    Enrollments in course : <a href='../course/?id=<?php echo $course_id?>'><?php echo $edxapp->courseName($course_id)?></a></h1>
    <ol class="breadcrumb">
        <li class="active"><i class="fa fa-book"></i> <?php echo explode('/', $course_id)[0]?></li>
        <li class="active"><?php echo explode('/', $course_id)[1]?></li>
        <li class="active"><a href='../course/?id=<?php echo $course_id?>'><?php echo explode('/', $course_id)[2]?></a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

<?php
if (!$edxCourse->exist($course_id)) {
    echo new Admin\Callout('Danger', 'Course "'.$course_id.'" not found', 'The course was not found or not available');
}
?>



<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-lg-6 connectedSortable">
        <?php

        include "box_enroll_info.php";

        include "box_search.php";
        ?>
    </section>

    <!-- Right col -->
    <section class="col-lg-6 connectedSortable">
        <?php
        $box=new Admin\SolidBox;
        $box->id("boxenroll");
        $box->title("List users");
        $box->icon("fa fa-list");
        $box->loading(true);
        echo $box->html("Search");
        ?>
    </section>
</div>



<script>


function getEnrollData(){
    
    //console.log('getEnrollData()');
    
    $("#boxenroll .overlay, #boxenroll .loading-img").show();//loading
    
    var r=$.ajax({
        type: "POST",
        url: "ctrl.php",
        dataType: "json",
        data: {
            'do':'listEnroll',
            'course_id':$('#course_id').val(),
            'search':$('#searchStr').val(),
            'limit':$('#limit').val()
        }
    });

    r.done(function(json){
        
        //console.log(json);
        //alert(json);
        
        /*
        $.each(json,function(k,v){
            //json[k].start=new Date(v.start);
            //json[k].end=new Date(v.end);
        });
        */
        
        dispEnroll(json, $("#boxenroll .box-body"));
        $("#boxenroll .overlay, #boxenroll .loading-img").hide();
    });

    r.fail(function(a,b,c){
        console.log('fail',a,b,c);
        $("#boxenroll .box-body").html(a.responseText);
    });
}

function dispEnroll(json, target){
    //console.log('dispEnroll()');
    
    var h=[];
    h.push("<table class='table table-striped table-condensed'>");
    h.push("<thead>");
    h.push("<th>User</th>");
    h.push("<th>Joined</th>");
    h.push("</thead>");
    h.push("<tbody>");
    $.each(json,function(k,v){
        h.push('<tr>');
        h.push('<td><a href=../user/?id='+v.user_id+'>'+v.username);
        h.push('<td>'+v.created);
        h.push('</tr>');
    });
    h.push("</tbody>");
    h.push("</table>");

    target.html(h.join(''));
}


$(function(){
    //console.log('ready');

    //$("#boxenroll .overlay, #boxenroll .loading-img").hide();
    $('#searchStr, #limit').change(function(){
        getEnrollData();
    });
    getEnrollData();
});

</script>