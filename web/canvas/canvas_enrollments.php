<?php
//admin :: canvas user import
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";


$admin = new Admin\AdminLte();
$admin->title("Canvas");

echo $admin->printPrivate();

$edxapp= new Admin\EdxApp();
$canvas= new Admin\Canvas();
?>

<section class="content-header">
    <h1><i class="fa fa-book"></i> Canvas enrollments<small></small></h1>
    <ol class="breadcrumb">
        <li><a href="index.php">Canvas Index</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

<?php
//print_r($_GET);
$course_id=$_GET['id'];


// stats
$box=new Admin\Box;
$box->type("danger");
$box->title("Course enroll. stats");

$htm=[];

$sql= "SELECT workflow_state, count(workflow_state) as count FROM enrollments ";
$sql.="WHERE course_id=$course_id GROUP BY workflow_state ORDER BY count DESC;";
$q = $canvas->db()->query($sql) or die("Error: $sql");

$html[]="<table class='table table-condensed'>";
while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
    $dat[]=$r;
    $html[]="<tr>";
    $html[]="<td><a href='canvas_userlist.php?course_id=$course_id&type=".$r['workflow_state']."'>".$r['workflow_state']."</a>";
    $html[]="<td>".$r['count'];
}
$html[]="</table>";


echo $box->html($html);



// data
$enrs=$canvas->courseEnrollments($_GET['id']);

$htm=[];
$htm[]= "<table class='table table-striped table-condensed'>";
$htm[]= "<thead>";
//$htm[]= "<th width=30>#</th>";
$htm[]= "<th>User</th>";
$htm[]= "<th>Type</th>";
$htm[]= "<th>Workflow st.</th>";
$htm[]= "<th>Created</th>";
$htm[]= "<th>Last activity</th>";
//$htm[]= "<th title='enrollments'>Enr.</th>";
//$htm[]= "<th>Edx Relation</th>";
$htm[]= "</thead>";

foreach ($enrs as $enr) {
    $htm[]= "<tr>";
    //echo "<td>".print_r($enr, true);
    
    //$htm[]= "<td>".$enr['id'];
    $htm[]= "<td><a href='canvas_user.php?id=".$enr['user_id']."'>".$enr['user_id'];
    $htm[]= "<td>".$enr['type'];
    $htm[]= "<td>".$enr['workflow_state'];
    $htm[]= "<td>".substr($enr['created_at'], 0, 10);
    $htm[]= "<td>".substr($enr['last_activity_at'], 0, 10);
    //$htm[]= "<td>".$course['restrict_enrollments_to_course_dates'];
    //$htm[]= "<td style='text-align:right'><a href='canvas_enrollments.php?id=".$course['id']."'>".number_format($canvas->courseEnrollCount($course['id']));
    //$htm[]= "<td><a href='../course/?id=".$course['edx_id']."'>".$course['edx_id'];
    
   $htm[]= "</tr>";
}
$htm[]= "</table>";

//echo "<pre>"; print_r($enr); echo "</pre>";

$box=new Admin\Box;
$box->type("danger");
$box->title(count($enrs) . " Enrollments");
//$box->icon("fa fa-book");
echo $box->html($htm);

//print_r($courses);
//$user_ids=$canvas->userIds();
//die("count:".count($user_ids));

?>
<script>
$(function(){
    $("table").tablesorter();
    console.log("ready");
});
</script>
