<?php
//admin :: canvas user list
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";


$admin = new Admin\AdminLte();
$admin->title("Canvas");

echo $admin->printPrivate();

$edxApp= new Admin\EdxApp();
$canvas= new Admin\Canvas();
?>

<section class="content-header">
    <h1><i class="fa fa-book"></i> Canvas userlist<small></small></h1>
    <ol class="breadcrumb">
        <li><a href="index.php">Canvas Index</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

<?php
echo "<pre>"; print_r($_GET); echo "</pre>";

$course_id=$_GET['course_id'];
$type=$_GET['type'];


// stats
/*
$box=new Admin\Box;
$box->type("danger");
$box->title("Course enroll. stats");
*/
$enrs=$canvas->courseEnrollments($course_id, $type);
echo "<table class='table table-condensed table-striped'>";
echo "<thead>";
echo "<th>#</th>";
echo "<th>user_id</th>";
echo "<th>name</th>";
echo "<th>email</th>";
echo "<th>created_at</th>";
echo "</thead>";
foreach($enrs as $r)
{
    //$usr=$edxApp->user($r['user_id']);
    $usr=$canvas->user($r['user_id']);
    //print_r($usr);exit;
    echo "<tr>";
    echo "<td>".$r['id'];
    echo "<td><a href='canvas_user.php?id=".$r['user_id']."'>".$r['user_id'];
    echo "<td>".$usr['name'];
    //echo "<td>".$usr['last_name'];
    echo "<td>".$usr['email'];
    echo "<td>".substr($r['created_at'],0,10);
}
echo "</table>";

?>
<script>
$(function(){
    $("table").tablesorter();
    console.log("ready");
});
</script>
