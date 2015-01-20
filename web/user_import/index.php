<?php
//admin :: User activity
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;
use Admin\EdxCrm;

$admin = new AdminLte();
$admin->title("User import");
echo $admin->printPrivate();

$edxApp = new EdxApp();

?>

<section class="content-header">
    <h1><i class='fa fa-users'></i> User import</h1>
</section>


<!-- Main content -->
<section class="content">


<?php
include "box_tools.php";


include "box_processing.php";//



// Temporary list
$box = new Admin\SolidBox;
$box->id('boxlist');
$box->icon("fa fa-users");
$box->title("Temporary user list");
$box->loading(true);

$foot=[];
$foot[]="<a href=#import class='btn btn-default' id='btnImport'><i class='fa fa-bolt'></i> Import users</a> ";
$foot[]="<a href=#clear class='btn btn-danger pull-right' onclick='clearList()'><i class='fa fa-trash-o'></i> Clear list</a> ";
echo $box->html("Please wait...",$foot);

//$sql="SELECT * FROM edxcrm.student_bulk_import WHERE 1;";
//$q=$admin->db()->query($sql) or die("Error:$sql");
//while($r=$q->fetch())print_r($r);


?>

<div id='more'></div>

</section>

<?php
include "edit_modal.php";
include "user_course_enroll_modal.php";
?>


<script src='user_import.js'></script>